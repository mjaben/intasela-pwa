document.addEventListener('DOMContentLoaded', function() {
    // Only run if the device supports touch
    if (!('ontouchstart' in window) && !navigator.maxTouchPoints) {
        return;
    }

    let startY = 0;
    let currentY = 0;
    let isPulling = false;
    const threshold = 75; // px to pull before refresh triggers
    let spinner = null;
    let spinnerIcon = null;

    function createSpinner() {
        if (spinner) return;

        spinner = document.createElement('div');
        spinner.style.position = 'fixed';
        spinner.style.top = '-50px';
        spinner.style.left = '50%';
        spinner.style.transform = 'translateX(-50%)';
        spinner.style.width = '40px';
        spinner.style.height = '40px';
        spinner.style.backgroundColor = '#ffffff';
        spinner.style.borderRadius = '50%';
        spinner.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';
        spinner.style.display = 'flex';
        spinner.style.justifyContent = 'center';
        spinner.style.alignItems = 'center';
        spinner.style.zIndex = '999999';
        spinner.style.transition = 'top 0.1s ease-out';
        
        // Add SVG spinner icon
        spinnerIcon = document.createElement('div');
        spinnerIcon.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.59-9.21l5.67-4.25"/></svg>';
        spinnerIcon.style.transition = 'transform 0.1s ease-out';
        spinnerIcon.style.display = 'flex';
        
        spinner.appendChild(spinnerIcon);
        document.body.appendChild(spinner);
    }

    window.addEventListener('touchstart', function(e) {
        if (window.scrollY === 0) {
            startY = e.touches[0].clientY;
            isPulling = true;
        }
    }, { passive: true });

    window.addEventListener('touchmove', function(e) {
        if (!isPulling) return;

        currentY = e.touches[0].clientY;
        const pullDistance = currentY - startY;

        // Only react if pulling downwards while at the very top of the page
        if (pullDistance > 0 && window.scrollY <= 0) {
            // Prevent default behavior to stop native overscroll (if possible)
            if (e.cancelable) {
                e.preventDefault();
            }

            createSpinner();
            
            // Apply resistance to the pull
            const visualDistance = Math.min(pullDistance * 0.4, threshold + 20);
            
            // Move spinner down
            spinner.style.top = `${-50 + visualDistance}px`;
            
            // Rotate the icon as it's pulled
            const rotation = (visualDistance / threshold) * 360;
            spinnerIcon.style.transform = `rotate(${rotation}deg)`;

            // Visual feedback if threshold met
            if (visualDistance >= threshold) {
                spinnerIcon.querySelector('svg').style.stroke = '#10b981'; // Green
            } else {
                spinnerIcon.querySelector('svg').style.stroke = '#4f46e5'; // Indigo
            }
        } else if (pullDistance < 0) {
            // Cancel pull if they scrolled down
            isPulling = false;
        }
    }, { passive: false });

    window.addEventListener('touchend', function(e) {
        if (!isPulling) return;
        isPulling = false;

        const pullDistance = currentY - startY;
        const visualDistance = Math.min(pullDistance * 0.4, threshold + 20);

        if (spinner) {
            if (visualDistance >= threshold) {
                // Threshold met, trigger refresh
                spinner.style.transition = 'top 0.3s ease-out';
                spinner.style.top = '15px';
                
                // Add infinite rotation animation
                spinnerIcon.style.animation = 'intaselaPwaSpin 1s linear infinite';
                if (!document.getElementById('intaselaPwaSpinKeyframes')) {
                    const style = document.createElement('style');
                    style.id = 'intaselaPwaSpinKeyframes';
                    style.innerHTML = '@keyframes intaselaPwaSpin { 100% { transform: rotate(360deg); } }';
                    document.head.appendChild(style);
                }

                // Reload the page
                setTimeout(() => {
                    window.location.reload(true);
                }, 300);
            } else {
                // Threshold not met, snap back
                spinner.style.transition = 'top 0.3s ease-in-out';
                spinner.style.top = '-50px';
                
                // Clean up DOM after animation
                setTimeout(() => {
                    if (spinner && spinner.parentNode) {
                        spinner.parentNode.removeChild(spinner);
                        spinner = null;
                    }
                }, 300);
            }
        }

        startY = 0;
        currentY = 0;
    }, { passive: true });
});
