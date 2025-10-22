
        function getLocation() {
            const locationInput = document.getElementById('location');
            const button = document.querySelector('.get-location-btn');
            
            if (navigator.geolocation) {
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                button.disabled = true;
                
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        // Using reverse geocoding service (in real app, you'd use Google Maps API)
                        fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lng}&localityLanguage=en`)
                            .then(response => response.json())
                            .then(data => {
                                locationInput.value = `${data.locality}, ${data.city}, ${data.principalSubdivision} (${lat.toFixed(6)}, ${lng.toFixed(6)})`;
                                button.innerHTML = '<i class="fas fa-check"></i>';
                                button.style.background = '#00b894';
                                setTimeout(() => {
                                    button.innerHTML = '<i class="fas fa-crosshairs"></i> Get Location';
                                    button.style.background = '#667eea';
                                    button.disabled = false;
                                }, 2000);
                            })
                            .catch(error => {
                                locationInput.value = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
                                button.innerHTML = '<i class="fas fa-crosshairs"></i> Get Location';
                                button.disabled = false;
                            });
                    },
                    function(error) {
                        alert('Error getting location: ' + error.message);
                        button.innerHTML = '<i class="fas fa-crosshairs"></i> Get Location';
                        button.disabled = false;
                    }
                );
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        }

        // Handle form submission
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const loading = document.getElementById('loading');
            const successMessage = document.getElementById('successMessage');
            const submitBtn = document.querySelector('.submit-btn');
            
            // Show loading
            loading.style.display = 'block';
            submitBtn.style.display = 'none';
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                alert('CSRF token not found. Please refresh the page.');
                loading.style.display = 'none';
                submitBtn.style.display = 'block';
                return;
            }
            
            // Prepare form data
            const formData = new FormData(this);
            
            // Send to Laravel backend
            fetch('/api/bookings', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                loading.style.display = 'none';
                submitBtn.style.display = 'block';
                
                if (data.success) {
                    successMessage.style.display = 'block';
                    this.reset();
                    
                    // Hide success message after 5 seconds
                    setTimeout(() => {
                        successMessage.style.display = 'none';
                    }, 5000);
                } else {
                    alert('Error: ' + (data.message || 'Something went wrong'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                loading.style.display = 'none';
                submitBtn.style.display = 'block';
                alert('Error submitting booking: ' + error.message + '. Please try again.');
            });
        });

        // Add some interactive animations
        document.querySelectorAll('.form-group input, .form-group textarea, .form-group select').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
