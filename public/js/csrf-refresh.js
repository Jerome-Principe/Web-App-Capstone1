/**
 * CSRF Token Auto-Refresh System
 * Prevents 419 Page Expired errors by keeping CSRF tokens fresh
 */

(function() {
    'use strict';
    
    let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    let refreshInterval;
    
    // Initialize CSRF refresh system
    function initCsrfRefresh() {
        if (!csrfToken) {
            console.warn('CSRF token not found in meta tag');
            return;
        }
        
        // Refresh CSRF token every 30 minutes (1800000 ms)
        refreshInterval = setInterval(refreshCsrfToken, 1800000);
        
        // Refresh token when user becomes active after being idle
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                refreshCsrfToken();
            }
        });
        
        // Refresh token before form submissions
        document.addEventListener('submit', function(e) {
            updateFormCsrfTokens();
        });
        
        // Handle AJAX setup
        setupAjaxCsrfHandling();
        
        console.log('CSRF auto-refresh initialized');
    }
    
    // Refresh CSRF token via AJAX
    function refreshCsrfToken() {
        fetch('/csrf-refresh', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            const newToken = response.headers.get('X-CSRF-TOKEN');
            if (newToken) {
                updateCsrfToken(newToken);
            }
        })
        .catch(error => {
            console.warn('Failed to refresh CSRF token:', error);
        });
    }
    
    // Update CSRF token in all forms and meta tags
    function updateCsrfToken(newToken) {
        csrfToken = newToken;
        
        // Update meta tag
        const metaTag = document.querySelector('meta[name="csrf-token"]');
        if (metaTag) {
            metaTag.setAttribute('content', newToken);
        }
        
        // Update all CSRF input fields
        updateFormCsrfTokens();
        
        console.log('CSRF token refreshed');
    }
    
    // Update CSRF tokens in all forms
    function updateFormCsrfTokens() {
        const csrfInputs = document.querySelectorAll('input[name="_token"]');
        csrfInputs.forEach(input => {
            input.value = csrfToken;
        });
    }
    
    // Setup AJAX CSRF handling
    function setupAjaxCsrfHandling() {
        // jQuery AJAX setup (if jQuery is available)
        if (window.jQuery) {
            jQuery.ajaxSetup({
                beforeSend: function(xhr, settings) {
                    if (!/^(GET|HEAD|OPTIONS|TRACE)$/i.test(settings.type) && !this.crossDomain) {
                        xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
                    }
                }
            });
        }
        
        // Fetch API interceptor
        const originalFetch = window.fetch;
        window.fetch = function(url, options = {}) {
            if (options.method && !['GET', 'HEAD', 'OPTIONS', 'TRACE'].includes(options.method.toUpperCase())) {
                options.headers = options.headers || {};
                options.headers['X-CSRF-TOKEN'] = csrfToken;
            }
            return originalFetch.call(this, url, options);
        };
    }
    
    // Handle 419 errors gracefully
    function handle419Error() {
        // Show user-friendly message
        if (confirm('Your session has expired. Would you like to refresh the page?')) {
            window.location.reload();
        } else {
            window.location.href = '/login';
        }
    }
    
    // Global error handler for 419 responses
    window.addEventListener('unhandledrejection', function(event) {
        if (event.reason && event.reason.status === 419) {
            event.preventDefault();
            handle419Error();
        }
    });
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCsrfRefresh);
    } else {
        initCsrfRefresh();
    }
    
    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
    });
    
})();
