@extends('layouts.admin')

@section('title', 'Content Management')

@section('content')
<div class="header">
    <h1><i class="fas fa-images"></i> Content Management</h1>
    <p>Manage hero slider and service grid content</p>
</div>

<!-- Success/Error Messages -->
<div id="successMessage" class="alert alert-success" style="display: none;"></div>
<div id="errorMessage" class="alert alert-danger" style="display: none;"></div>

<div class="content-management" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
    <!-- Hero Slider Management -->
    <div class="content-card">
        <div class="card-header">
            <h3><i class="fas fa-sliders-h"></i> Hero Slider Management</h3>
            <button class="btn btn-primary" onclick="addNewSlide()">
                <i class="fas fa-plus"></i> Add Slide
            </button>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Current Slides</label>
                <div class="items-list" id="sliderItems" style="max-height: 400px; overflow-y: auto; border: 1px solid #e1e5e9; border-radius: 8px;">
                    <div class="text-center" style="padding: 20px;">
                        <div class="loading"></div>
                        <p>Loading slides...</p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Add New Slide</label>
                <div class="file-upload-container" id="sliderUploadContainer" style="border: 2px dashed #ddd; border-radius: 8px; padding: 30px; text-align: center; transition: all 0.3s ease; background: #fafafa;">
                    <label class="file-upload-label" style="cursor: pointer; display: block;">
                        <div class="file-upload-icon" style="font-size: 3rem; color: #667eea; margin-bottom: 15px;">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="file-upload-text" style="color: #666; margin-bottom: 15px;">
                            <strong>Click to upload</strong> or drag and drop<br>
                            <small>Supports: JPG, PNG, MP4, WebM (Max: 10MB)</small>
                        </div>
                        <input type="file" class="file-input" id="sliderFileInput" accept="image/*,video/*" style="display: none;">
                    </label>
                    <div class="file-preview" id="sliderFilePreview" style="margin-top: 15px; display: none;"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="slideTitle">Slide Title</label>
                <input type="text" class="form-control" id="slideTitle" placeholder="Enter slide title">
            </div>

            <div class="form-group">
                <label for="slideDescription">Slide Description</label>
                <textarea class="form-control" id="slideDescription" placeholder="Enter slide description"></textarea>
            </div>

            <div class="form-group">
                <label class="toggle-switch" style="position: relative; display: inline-block; width: 50px; height: 24px;">
                    <input type="checkbox" id="slideActive" checked>
                    <span class="toggle-slider" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 24px;"></span>
                </label>
                <span style="margin-left: 10px;">Active Slide</span>
            </div>

            <button class="btn btn-success" onclick="saveSlide()" style="width: 100%;">
                <i class="fas fa-save"></i> Save Slide
            </button>
        </div>
    </div>

    <!-- Service Grid Management -->
    <div class="content-card">
        <div class="card-header">
            <h3><i class="fas fa-th"></i> Service Grid Management</h3>
            <button class="btn btn-primary" onclick="addNewService()">
                <i class="fas fa-plus"></i> Add Service
            </button>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Current Services</label>
                <div class="items-list" id="serviceItems" style="max-height: 400px; overflow-y: auto; border: 1px solid #e1e5e9; border-radius: 8px;">
                    <div class="text-center" style="padding: 20px;">
                        <div class="loading"></div>
                        <p>Loading services...</p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Service Media</label>
                <div class="file-upload-container" id="serviceUploadContainer" style="border: 2px dashed #ddd; border-radius: 8px; padding: 30px; text-align: center; transition: all 0.3s ease; background: #fafafa;">
                    <label class="file-upload-label" style="cursor: pointer; display: block;">
                        <div class="file-upload-icon" style="font-size: 3rem; color: #667eea; margin-bottom: 15px;">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="file-upload-text" style="color: #666; margin-bottom: 15px;">
                            <strong>Click to upload</strong> or drag and drop<br>
                            <small>Supports: JPG, PNG, MP4, WebM (Max: 10MB)</small>
                        </div>
                        <input type="file" class="file-input" id="serviceFileInput" accept="image/*,video/*" style="display: none;">
                    </label>
                    <div class="file-preview" id="serviceFilePreview" style="margin-top: 15px; display: none;"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="serviceTitle">Service Title</label>
                <input type="text" class="form-control" id="serviceTitle" placeholder="Enter service title">
            </div>

            <div class="form-group">
                <label for="serviceDescription">Service Description</label>
                <textarea class="form-control" id="serviceDescription" placeholder="Enter service description"></textarea>
            </div>

            <div class="form-group">
                <label for="servicePrice">Price</label>
                <input type="text" class="form-control" id="servicePrice" placeholder="e.g., Starting from ₹499">
            </div>

            <div class="form-group">
                <label>Service Features</label>
                <div class="features-list" id="serviceFeatures" style="display: grid; gap: 10px; margin-top: 15px;">
                    <div class="feature-item" style="display: flex; align-items: center; gap: 10px; padding: 8px 12px; background: #f8f9fa; border-radius: 6px;">
                        <input type="text" class="feature-input" placeholder="Enter feature" style="flex: 1; padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                        <button type="button" class="remove-feature" onclick="removeFeature(this)" style="background: #dc3545; color: white; border: none; width: 30px; height: 30px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <button type="button" class="add-feature" onclick="addFeature()" style="background: #28a745; color: white; border: none; padding: 8px 15px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 5px; font-size: 0.9rem; margin-top: 10px;">
                    <i class="fas fa-plus"></i> Add Feature
                </button>
            </div>

            <div class="form-group">
                <label for="serviceDetails">Detailed Description</label>
                <textarea class="form-control" id="serviceDetails" placeholder="Enter detailed service description" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label class="toggle-switch" style="position: relative; display: inline-block; width: 50px; height: 24px;">
                    <input type="checkbox" id="serviceActive" checked>
                    <span class="toggle-slider" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 24px;"></span>
                </label>
                <span style="margin-left: 10px;">Active Service</span>
            </div>

            <button class="btn btn-success" onclick="saveService()" style="width: 100%;">
                <i class="fas fa-save"></i> Save Service
            </button>
        </div>
    </div>
</div>

<!-- Preview Section -->
<div class="preview-section">
    <div class="content-card">
        <div class="card-header">
            <h3><i class="fas fa-eye"></i> Live Preview</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <div>
                    <h4 style="margin-bottom: 15px;">Slider Preview</h4>
                    <div id="sliderPreview" style="border: 2px dashed #ddd; border-radius: 10px; padding: 20px; text-align: center; min-height: 200px; display: flex; align-items: center; justify-content: center;">
                        <div style="color: #666;">
                            <i class="fas fa-sliders-h" style="font-size: 3rem; margin-bottom: 15px;"></i>
                            <p>Slider preview will appear here</p>
                        </div>
                    </div>
                </div>
                <div>
                    <h4 style="margin-bottom: 15px;">Service Grid Preview</h4>
                    <div id="servicePreview" style="border: 2px dashed #ddd; border-radius: 10px; padding: 20px; text-align: center; min-height: 200px; display: flex; align-items: center; justify-content: center;">
                        <div style="color: #666;">
                            <i class="fas fa-th" style="font-size: 3rem; margin-bottom: 15px;"></i>
                            <p>Service grid preview will appear here</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Global variables
    let currentEditingSlide = null;
    let currentEditingService = null;

    // CSRF token for AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Initialize the page
    document.addEventListener('DOMContentLoaded', function() {
        loadSlides();
        loadServices();
        setupFileUploads();
    });

    // Load slides from backend
    async function loadSlides() {
        try {
            const response = await fetch(`${baseUrl}/admin/content/sliders`, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });
            
            const sliders = await response.json();
            displaySliders(sliders);
            updateSliderPreview(sliders);
        } catch (error) {
            console.error('Error loading slides:', error);
            showMessage('Failed to load slides', 'error');
        }
    }

    // Load services from backend
    async function loadServices() {
        try {
            const response = await fetch('/admin/content/services', {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });
            
            const services = await response.json();
            displayServices(services);
            updateServicePreview(services);
        } catch (error) {
            console.error('Error loading services:', error);
            showMessage('Failed to load services', 'error');
        }
    }

    // Display sliders in the list
    function displaySliders(sliders) {
        const container = document.getElementById('sliderItems');
        
        if (sliders.length === 0) {
            container.innerHTML = `
                <div class="text-center" style="padding: 40px; color: #666;">
                    <i class="fas fa-images" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;"></i>
                    <p>No slides added yet</p>
                </div>
            `;
            return;
        }

        container.innerHTML = sliders.map(slider => `
            <div class="item-card" data-id="${slider.id}" style="padding: 15px; border-bottom: 1px solid #e1e5e9; display: flex; align-items: center; gap: 15px; transition: background-color 0.3s ease;">
                <div class="item-media" style="width: 80px; height: 60px; border-radius: 6px; overflow: hidden; flex-shrink: 0;">
                    ${slider.media_type === 'image' ? 
                        `<img src="${slider.media_url}" alt="${slider.title}" style="width: 100%; height: 100%; object-fit: cover;">` : 
                        `<video src="${slider.media_url}" style="width: 100%; height: 100%; object-fit: cover;"></video>`
                    }
                </div>
                <div class="item-content" style="flex: 1; min-width: 0;">
                    <div class="item-title" style="font-weight: 600; color: #333; margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${slider.title}</div>
                    <div class="item-meta" style="font-size: 0.8rem; color: #666;">
                        <span class="media-badge ${slider.media_type === 'image' ? 'badge-image' : 'badge-video'}" style="display: inline-block; padding: 3px 8px; border-radius: 12px; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; background: ${slider.media_type === 'image' ? '#e3f2fd' : '#fff3e0'}; color: ${slider.media_type === 'image' ? '#1976d2' : '#f57c00'};">
                            ${slider.media_type}
                        </span>
                        ${slider.is_active ? '<span style="color: #28a745;">• Active</span>' : '<span style="color: #dc3545;">• Inactive</span>'}
                    </div>
                </div>
                <div class="item-actions" style="display: flex; gap: 8px; flex-shrink: 0;">
                    <button class="btn btn-info btn-sm" onclick="editSlide(${slider.id})" style="padding: 6px 12px; font-size: 0.8rem;">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="deleteSlide(${slider.id})" style="padding: 6px 12px; font-size: 0.8rem;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `).join('');
    }

    // Display services in the list
    function displayServices(services) {
        const container = document.getElementById('serviceItems');
        
        if (services.length === 0) {
            container.innerHTML = `
                <div class="text-center" style="padding: 40px; color: #666;">
                    <i class="fas fa-th" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;"></i>
                    <p>No services added yet</p>
                </div>
            `;
            return;
        }

        container.innerHTML = services.map(service => `
            <div class="item-card" data-id="${service.id}" style="padding: 15px; border-bottom: 1px solid #e1e5e9; display: flex; align-items: center; gap: 15px; transition: background-color 0.3s ease;">
                <div class="item-media" style="width: 80px; height: 60px; border-radius: 6px; overflow: hidden; flex-shrink: 0;">
                    ${service.media_type === 'image' ? 
                        `<img src="${service.media_url}" alt="${service.title}" style="width: 100%; height: 100%; object-fit: cover;">` : 
                        `<video src="${service.media_url}" style="width: 100%; height: 100%; object-fit: cover;"></video>`
                    }
                </div>
                <div class="item-content" style="flex: 1; min-width: 0;">
                    <div class="item-title" style="font-weight: 600; color: #333; margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${service.title}</div>
                    <div class="item-meta" style="font-size: 0.8rem; color: #666;">
                        <span class="media-badge ${service.media_type === 'image' ? 'badge-image' : 'badge-video'}" style="display: inline-block; padding: 3px 8px; border-radius: 12px; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; background: ${service.media_type === 'image' ? '#e3f2fd' : '#fff3e0'}; color: ${service.media_type === 'image' ? '#1976d2' : '#f57c00'};">
                            ${service.media_type}
                        </span>
                        • ${service.price}
                        ${service.is_active ? '<span style="color: #28a745;">• Active</span>' : '<span style="color: #dc3545;">• Inactive</span>'}
                    </div>
                </div>
                <div class="item-actions" style="display: flex; gap: 8px; flex-shrink: 0;">
                    <button class="btn btn-info btn-sm" onclick="editService(${service.id})" style="padding: 6px 12px; font-size: 0.8rem;">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="deleteService(${service.id})" style="padding: 6px 12px; font-size: 0.8rem;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `).join('');
    }

    // Save slide to backend
    async function saveSlide() {
        const formData = new FormData();
        const title = document.getElementById('slideTitle').value.trim();
        const description = document.getElementById('slideDescription').value.trim();
        const isActive = document.getElementById('slideActive').checked;
        const fileInput = document.getElementById('sliderFileInput');
        const file = fileInput.files[0];

        if (!title) {
            showMessage('Please enter a slide title', 'error');
            return;
        }

        if (!file && !currentEditingSlide) {
            showMessage('Please select an image or video for the slide', 'error');
            return;
        }

        formData.append('title', title);
        formData.append('description', description);
        formData.append('is_active', isActive);
        if (file) formData.append('media', file);

        try {
            const url = currentEditingSlide 
                ? `${baseUrl}/admin/content/sliders/${currentEditingSlide.id}`
                : `${baseUrl}/admin/content/sliders`;
            
            const method = currentEditingSlide ? 'PUT' : 'POST';

            const response = await fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                showMessage(result.message, 'success');
                loadSlides();
                addNewSlide(); // Reset form
            } else {
                showMessage(result.message, 'error');
            }
        } catch (error) {
            console.error('Error saving slide:', error);
            showMessage('Failed to save slide', 'error');
        }
    }

    // Save service to backend
    async function saveService() {
        const formData = new FormData();
        const title = document.getElementById('serviceTitle').value.trim();
        const description = document.getElementById('serviceDescription').value.trim();
        const price = document.getElementById('servicePrice').value.trim();
        const details = document.getElementById('serviceDetails').value.trim();
        const isActive = document.getElementById('serviceActive').checked;
        const fileInput = document.getElementById('serviceFileInput');
        const file = fileInput.files[0];

        // Get features
        const featureInputs = document.querySelectorAll('.feature-input');
        const features = Array.from(featureInputs)
            .map(input => input.value.trim())
            .filter(feature => feature !== '');

        if (!title) {
            showMessage('Please enter a service title', 'error');
            return;
        }

        if (!file && !currentEditingService) {
            showMessage('Please select an image or video for the service', 'error');
            return;
        }

        formData.append('title', title);
        formData.append('description', description);
        formData.append('price', price);
        formData.append('details', details);
        formData.append('is_active', isActive);
        features.forEach(feature => formData.append('features[]', feature));
        if (file) formData.append('media', file);

        try {
            const url = currentEditingService 
                ? `/admin/content/services/${currentEditingService.id}`
                : '/admin/content/services';
            
            const method = currentEditingService ? 'PUT' : 'POST';

            const response = await fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                showMessage(result.message, 'success');
                loadServices();
                addNewService(); // Reset form
            } else {
                showMessage(result.message, 'error');
            }
        } catch (error) {
            console.error('Error saving service:', error);
            showMessage('Failed to save service', 'error');
        }
    }

    // Delete slide
    async function deleteSlide(slideId) {
        if (!confirm('Are you sure you want to delete this slide?')) return;

        try {
            const response = await fetch(`${baseUrl}/admin/content/sliders/${slideId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            const result = await response.json();

            if (result.success) {
                showMessage(result.message, 'success');
                loadSlides();
            } else {
                showMessage(result.message, 'error');
            }
        } catch (error) {
            console.error('Error deleting slide:', error);
            showMessage('Failed to delete slide', 'error');
        }
    }

    // Delete service
    async function deleteService(serviceId) {
        if (!confirm('Are you sure you want to delete this service?')) return;

        try {
            const response = await fetch(`/admin/content/services/${serviceId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            const result = await response.json();

            if (result.success) {
                showMessage(result.message, 'success');
                loadServices();
            } else {
                showMessage(result.message, 'error');
            }
        } catch (error) {
            console.error('Error deleting service:', error);
            showMessage('Failed to delete service', 'error');
        }
    }

    // Edit slide
    function editSlide(slideId) {
        // Fetch slide details and populate form
        fetch(`${baseUrl}/admin/content/sliders`)
            .then(response => response.json())
            .then(sliders => {
                const slide = sliders.find(s => s.id == slideId);
                if (slide) {
                    currentEditingSlide = slide;
                    document.getElementById('slideTitle').value = slide.title;
                    document.getElementById('slideDescription').value = slide.description || '';
                    document.getElementById('slideActive').checked = slide.is_active;
                    
                    // Show existing media preview
                    const preview = document.getElementById('sliderFilePreview');
                    preview.innerHTML = `
                        ${slide.media_type === 'image' ? 
                            `<img src="${slide.media_url}" alt="${slide.title}" style="max-width: 100%; max-height: 200px; border-radius: 8px;">` :
                            `<video src="${slide.media_url}" controls style="max-width: 100%; max-height: 200px; border-radius: 8px;"></video>`
                        }
                        <div class="file-info" style="margin-top: 10px; font-size: 0.9rem; color: #666;">
                            <small>Existing media - ${slide.media_type}</small>
                        </div>
                    `;
                    preview.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error loading slide details:', error);
                showMessage('Failed to load slide details', 'error');
            });
    }

    // Edit service
    function editService(serviceId) {
        // Fetch service details and populate form
        fetch(`/admin/content/services`)
            .then(response => response.json())
            .then(services => {
                const service = services.find(s => s.id == serviceId);
                if (service) {
                    currentEditingService = service;
                    document.getElementById('serviceTitle').value = service.title;
                    document.getElementById('serviceDescription').value = service.description;
                    document.getElementById('servicePrice').value = service.price;
                    document.getElementById('serviceDetails').value = service.details;
                    document.getElementById('serviceActive').checked = service.is_active;
                    
                    // Load features
                    const featuresContainer = document.getElementById('serviceFeatures');
                    featuresContainer.innerHTML = service.features.map(feature => `
                        <div class="feature-item" style="display: flex; align-items: center; gap: 10px; padding: 8px 12px; background: #f8f9fa; border-radius: 6px;">
                            <input type="text" class="feature-input" value="${feature}" style="flex: 1; padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                            <button type="button" class="remove-feature" onclick="removeFeature(this)" style="background: #dc3545; color: white; border: none; width: 30px; height: 30px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `).join('');
                    
                    // Show existing media preview
                    const preview = document.getElementById('serviceFilePreview');
                    preview.innerHTML = `
                        ${service.media_type === 'image' ? 
                            `<img src="${service.media_url}" alt="${service.title}" style="max-width: 100%; max-height: 200px; border-radius: 8px;">` :
                            `<video src="${service.media_url}" controls style="max-width: 100%; max-height: 200px; border-radius: 8px;"></video>`
                        }
                        <div class="file-info" style="margin-top: 10px; font-size: 0.9rem; color: #666;">
                            <small>Existing media - ${service.media_type}</small>
                        </div>
                    `;
                    preview.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error loading service details:', error);
                showMessage('Failed to load service details', 'error');
            });
    }

    // Add new slide (reset form)
    function addNewSlide() {
        currentEditingSlide = null;
        document.getElementById('slideTitle').value = '';
        document.getElementById('slideDescription').value = '';
        document.getElementById('slideActive').checked = true;
        document.getElementById('sliderFileInput').value = '';
        document.getElementById('sliderFilePreview').style.display = 'none';
        document.getElementById('sliderFilePreview').innerHTML = '';
    }

    // Add new service (reset form)
    function addNewService() {
        currentEditingService = null;
        document.getElementById('serviceTitle').value = '';
        document.getElementById('serviceDescription').value = '';
        document.getElementById('servicePrice').value = '';
        document.getElementById('serviceDetails').value = '';
        document.getElementById('serviceActive').checked = true;
        document.getElementById('serviceFileInput').value = '';
        document.getElementById('serviceFilePreview').style.display = 'none';
        document.getElementById('serviceFilePreview').innerHTML = '';
        
        // Reset features
        const featuresContainer = document.getElementById('serviceFeatures');
        featuresContainer.innerHTML = `
            <div class="feature-item" style="display: flex; align-items: center; gap: 10px; padding: 8px 12px; background: #f8f9fa; border-radius: 6px;">
                <input type="text" class="feature-input" placeholder="Enter feature" style="flex: 1; padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                <button type="button" class="remove-feature" onclick="removeFeature(this)" style="background: #dc3545; color: white; border: none; width: 30px; height: 30px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
    }

    // Feature management
    function addFeature() {
        const featuresContainer = document.getElementById('serviceFeatures');
        const newFeature = document.createElement('div');
        newFeature.className = 'feature-item';
        newFeature.style.cssText = 'display: flex; align-items: center; gap: 10px; padding: 8px 12px; background: #f8f9fa; border-radius: 6px;';
        newFeature.innerHTML = `
            <input type="text" class="feature-input" placeholder="Enter feature" style="flex: 1; padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
            <button type="button" class="remove-feature" onclick="removeFeature(this)" style="background: #dc3545; color: white; border: none; width: 30px; height: 30px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        `;
        featuresContainer.appendChild(newFeature);
    }

    function removeFeature(button) {
        const featureItem = button.parentElement;
        if (document.querySelectorAll('.feature-item').length > 1) {
            featureItem.remove();
        } else {
            // Don't remove the last one, just clear it
            featureItem.querySelector('.feature-input').value = '';
        }
    }

    // File upload setup
    function setupFileUploads() {
        // Slider file upload
        const sliderUpload = document.getElementById('sliderUploadContainer');
        const sliderFileInput = document.getElementById('sliderFileInput');
        const sliderPreview = document.getElementById('sliderFilePreview');

        setupFileUpload(sliderUpload, sliderFileInput, sliderPreview);

        // Service file upload
        const serviceUpload = document.getElementById('serviceUploadContainer');
        const serviceFileInput = document.getElementById('serviceFileInput');
        const servicePreview = document.getElementById('serviceFilePreview');

        setupFileUpload(serviceUpload, serviceFileInput, servicePreview);
    }

    function setupFileUpload(container, fileInput, preview) {
        // Click to upload
        container.addEventListener('click', () => fileInput.click());

        // Drag and drop
        container.addEventListener('dragover', (e) => {
            e.preventDefault();
            container.style.borderColor = '#667eea';
            container.style.background = '#f0f4ff';
        });

        container.addEventListener('dragleave', () => {
            container.style.borderColor = '#ddd';
            container.style.background = '#fafafa';
        });

        container.addEventListener('drop', (e) => {
            e.preventDefault();
            container.style.borderColor = '#ddd';
            container.style.background = '#fafafa';
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                handleFileSelect(fileInput, preview);
            }
        });

        // File selection
        fileInput.addEventListener('change', () => handleFileSelect(fileInput, preview));
    }

    function handleFileSelect(fileInput, preview) {
        const file = fileInput.files[0];
        if (!file) return;

        // Validate file type and size
        const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        const validVideoTypes = ['video/mp4', 'video/webm', 'video/ogg'];
        
        if (!validImageTypes.includes(file.type) && !validVideoTypes.includes(file.type)) {
            showMessage('Please select a valid image or video file', 'error');
            return;
        }

        if (file.size > 10 * 1024 * 1024) { // 10MB limit
            showMessage('File size must be less than 10MB', 'error');
            return;
        }

        // Create preview
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '';
            
            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '100%';
                img.style.maxHeight = '200px';
                img.style.borderRadius = '8px';
                preview.appendChild(img);
            } else if (file.type.startsWith('video/')) {
                const video = document.createElement('video');
                video.src = e.target.result;
                video.controls = true;
                video.style.maxWidth = '100%';
                video.style.maxHeight = '200px';
                video.style.borderRadius = '8px';
                preview.appendChild(video);
            }

            const fileInfo = document.createElement('div');
            fileInfo.className = 'file-info';
            fileInfo.style.marginTop = '10px';
            fileInfo.style.fontSize = '0.9rem';
            fileInfo.style.color = '#666';
            fileInfo.innerHTML = `
                <strong>${file.name}</strong><br>
                <small>${(file.size / 1024 / 1024).toFixed(2)} MB • ${file.type}</small>
            `;
            preview.appendChild(fileInfo);

            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    // Preview functions
    function updateSliderPreview(sliders) {
        const preview = document.getElementById('sliderPreview');
        const activeSlides = sliders.filter(slide => slide.is_active);
        
        if (activeSlides.length === 0) {
            preview.innerHTML = `
                <div style="color: #666;">
                    <i class="fas fa-sliders-h" style="font-size: 3rem; margin-bottom: 15px;"></i>
                    <p>No active slides to preview</p>
                </div>
            `;
            return;
        }

        preview.innerHTML = `
            <div style="width: 100%; max-width: 600px; margin: 0 auto;">
                <div style="position: relative; height: 200px; background: #f8f9fa; border-radius: 8px; overflow: hidden;">
                    ${activeSlides[0].media_type === 'image' ? 
                        `<img src="${activeSlides[0].media_url}" style="width: 100%; height: 100%; object-fit: cover;" alt="${activeSlides[0].title}">` :
                        `<video src="${activeSlides[0].media_url}" style="width: 100%; height: 100%; object-fit: cover;" autoplay muted loop></video>`
                    }
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.7); color: white; padding: 15px;">
                        <h4 style="margin: 0 0 5px 0; font-size: 1.2rem;">${activeSlides[0].title}</h4>
                        <p style="margin: 0; font-size: 0.9rem;">${activeSlides[0].description}</p>
                    </div>
                </div>
                <div style="margin-top: 10px; text-align: center; color: #666;">
                    <small>Previewing 1 of ${activeSlides.length} slides</small>
                </div>
            </div>
        `;
    }

    function updateServicePreview(services) {
        const preview = document.getElementById('servicePreview');
        const activeServices = services.filter(service => service.is_active);
        
        if (activeServices.length === 0) {
            preview.innerHTML = `
                <div style="color: #666;">
                    <i class="fas fa-th" style="font-size: 3rem; margin-bottom: 15px;"></i>
                    <p>No active services to preview</p>
                </div>
            `;
            return;
        }

        // Show first 3 services in preview
        const previewServices = activeServices.slice(0, 3);
        preview.innerHTML = `
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; width: 100%;">
                ${previewServices.map(service => `
                    <div style="background: white; border: 1px solid #e1e5e9; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                        <div style="height: 100px; background: #f8f9fa;">
                            ${service.media_type === 'image' ? 
                                `<img src="${service.media_url}" style="width: 100%; height: 100%; object-fit: cover;" alt="${service.title}">` :
                                `<video src="${service.media_url}" style="width: 100%; height: 100%; object-fit: cover;" muted></video>`
                            }
                        </div>
                        <div style="padding: 10px;">
                            <div style="font-weight: 600; font-size: 0.9rem; margin-bottom: 5px;">${service.title}</div>
                            <div style="font-size: 0.8rem; color: #28a745; font-weight: 600;">${service.price}</div>
                        </div>
                    </div>
                `).join('')}
            </div>
            ${activeServices.length > 3 ? 
                `<div style="margin-top: 10px; text-align: center; color: #666;">
                    <small>+ ${activeServices.length - 3} more services</small>
                </div>` : ''
            }
        `;
    }

    // Utility function to show messages
    function showMessage(message, type) {
        const successMsg = document.getElementById('successMessage');
        const errorMsg = document.getElementById('errorMessage');

        if (type === 'success') {
            successMsg.textContent = message;
            successMsg.style.display = 'block';
            errorMsg.style.display = 'none';
            
            setTimeout(() => {
                successMsg.style.display = 'none';
            }, 5000);
        } else {
            errorMsg.textContent = message;
            errorMsg.style.display = 'block';
            successMsg.style.display = 'none';
            
            setTimeout(() => {
                errorMsg.style.display = 'none';
            }, 5000);
        }
    }
</script>
@endsection