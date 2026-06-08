document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.DeviceMotionEvent === 'undefined') {
        return; // Device doesn't support motion events
    }

    const shakeThreshold = 15; // Velocity threshold
    let lastX = null, lastY = null, lastZ = null;
    let lastUpdate = 0;
    let shakeTimer = null;

    function handleMotion(event) {
        const current = event.accelerationIncludingGravity;
        if (!current || current.x === null) return;

        const currentTime = new Date().getTime();
        if ((currentTime - lastUpdate) > 100) {
            const diffTime = (currentTime - lastUpdate);
            lastUpdate = currentTime;

            if (lastX !== null) {
                const speed = Math.abs(current.x + current.y + current.z - lastX - lastY - lastZ) / diffTime * 10000;

                if (speed > shakeThreshold * 100) {
                    // Shake detected
                    if (!shakeTimer) {
                        shakeTimer = setTimeout(() => {
                            shakeTimer = null;
                            window.location.reload(true);
                        }, 500); // Prevent multiple reloads from a single shake
                    }
                }
            }
            
            lastX = current.x;
            lastY = current.y;
            lastZ = current.z;
        }
    }

    // Try to attach listener immediately
    window.addEventListener('devicemotion', handleMotion, false);

    // iOS 13+ requires explicit permission via a user interaction to use DeviceMotionEvent.
    // If the event listener above fails to receive data, we attach a one-time click listener
    // to the document to request permission on the first tap the user makes on the page.
    let permissionRequested = false;
    document.body.addEventListener('click', function requestMotionPermission() {
        if (permissionRequested) return;
        
        if (typeof DeviceMotionEvent.requestPermission === 'function') {
            DeviceMotionEvent.requestPermission()
                .then(permissionState => {
                    if (permissionState === 'granted') {
                        window.removeEventListener('devicemotion', handleMotion);
                        window.addEventListener('devicemotion', handleMotion, false);
                    }
                })
                .catch(console.error);
        }
        
        permissionRequested = true;
        document.body.removeEventListener('click', requestMotionPermission);
    }, { once: true });
});
