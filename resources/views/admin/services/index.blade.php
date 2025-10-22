@extends('layouts.admin')

@section('title', 'Service Management')

@section('content')
<div class="header">
    <h1><i class="fas fa-th"></i> Service Management</h1>
    <p>Manage service grid content and order</p>
</div>

<!-- Success/Error Messages -->
<div id="successMessage" class="alert alert-success" style="display: none;"></div>
<div id="errorMessage" class="alert alert-danger" style="display: none;"></div>

<div class="content-management" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
    <!-- Add/Edit Service Form -->
    <div class="content-card">
        <div class="card-header">
            <h3><i class="fas fa-plus-circle"></i> <span id="formTitle">Add New Service</span></h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Service Media *</label>
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
                <label for="serviceTitle">Service Title *</label>
                <input type="text" class="form-control" id="serviceTitle" placeholder="Enter service title" required>
            </div>

            <div class="form-group">
                <label for="serviceDescription">Short Description *</label>
                <textarea class="form-control" id="serviceDescription" placeholder="Enter short description" rows="2" required></textarea>
            </div>

            <div class="form-group">
                <label for="servicePrice">Price *</label>
                <input type="text" class="form-control" id="servicePrice" placeholder="e.g., Starting from ₹499" required>
            </div>

            <div class="form-group">
                <label>Service Features *</label>
                <div class="features-list" id="serviceFeatures" style="display: grid; gap: 10px; margin-top: 15px;">
                    <div class="feature-item" style="display: flex; align-items: center; gap: 10px; padding: 8px 12px; background: #f8f9fa; border-radius: 6px;">
                        <input type="text" class="feature-input form-control" placeholder="Enter feature" required>
                        <button type="button" class="remove-feature btn btn-danger btn-sm" onclick="removeFeature(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <button type="button" class="btn btn-success btn-sm mt-2" onclick="addFeature()">
                    <i class="fas fa-plus"></i> Add Feature
                </button>
            </div>

            <div class="form-group">
                <label for="serviceDetails">Detailed Description *</label>
                <textarea class="form-control" id="serviceDetails" placeholder="Enter detailed service description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label class="toggle-switch" style="position: relative; display: inline-block; width: 50px; height: 24px;">
                    <input type="checkbox" id="serviceActive" checked>
                    <span class="toggle-slider" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 24px;"></span>
                </label>
                <span style="margin-left: 10px;">Active Service</span>
            </div>

            <div class="form-actions" style="display: flex; gap: 10px;">
                <button class="btn btn-success" onclick="saveService()" style="flex: 1;">
                    <i class="fas fa-save"></i> <span id="saveButtonText">Save Service</span>
                </button>
                <button class="btn btn-secondary" onclick="resetForm()" id="cancelButton" style="display: none;">
                    <i class="fas fa-times"></i> Cancel
                </button>
            </div>
        </div>
    </div>

    <!-- Preview Section -->
    <div class="content-card">
        <div class="card-header">
            <h3><i class="fas fa-eye"></i> Live Preview</h3>
        </div>
        <div class="card-body">
            <div id="servicePreview" style="border: 2px dashed #ddd; border-radius: 10px; padding: 20px; text-align: center; min-height: 300px; display: flex; align-items: center; justify-content: center;">
                <div style="color: #666;">
                    <i class="fas fa-th" style="font-size: 3rem; margin-bottom: 15px;"></i>
                    <p>Service preview will appear here</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Service List -->
<div class="content-card">
    <div class="card-header">
        <h3><i class="fas fa-list"></i> Current Services (<span id="serviceCount">0</span>)</h3>
        <div style="display: flex; gap: 10px;">
            <button class="btn btn-info" onclick="loadServices()">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
            <button class="btn btn-primary" onclick="saveOrder()" id="saveOrderBtn" style="display: none;">
                <i class="fas fa-save"></i> Save Order
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="items-list" id="serviceItems" style="min-height: 200px;">
            <div class="text-center" style="padding: 40px;">
                <div class="loading"></div>
                <p>Loading services...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Global variables
    let currentEditingService = null;
    let isReorderMode = false;

    // CSRF token for AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Initialize the page
    document.addEventListener('DOMContentLoaded', function() {
        loadServices();
        setupFileUpload();
    });

    // Load services from backend
    async function loadServices() {
        try {
            showLoading('serviceItems');
            const response = await fetch('/admin/services', {
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

    // Display services in the list
    function displayServices(services) {
        const container = document.getElementById('serviceItems');
        document.getElementById('serviceCount').textContent = services.length;
        
        if (services.length === 0) {
            container.innerHTML = `
                <div class="text-center" style="padding: 40px; color: #666;">
                    <i class="fas fa-th" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;"></i>
                    <p>No services added yet</p>
                    <button class="btn btn-primary" onclick="resetForm()">
                        <i class="fas fa-plus"></i> Add Your First Service
                    </button>
                </div>
            `;
            return;
        }

        container.innerHTML = `
            <div style="margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <strong>Drag to reorder services</strong>
                    <small style="color: #666; margin-left: 10px;">The order affects how services appear on the homepage</small>
                </div>
                <button class="btn btn-sm ${isReorderMode ? 'btn-success' : 'btn-outline-primary'}" onclick="toggleReorderMode()">
                    <i class="fas fa-arrows-alt"></i> ${isReorderMode ? 'Save Order' : 'Reorder'}
                </button>
            </div>
            <div id="servicesSortable" style="display: grid; gap: 10px;">
                ${services.map(service => `
                    <div class="item-card" data-id="${service.id}" style="padding: 15px; border: 1px solid #e1e5e9; border-radius: 8px; background: white; display: flex; align-items: center; gap: 15px; transition: all 0.3s ease; cursor: ${isReorderMode ? 'move' : 'default'};">
                        ${isReorderMode ? `
                            <div class="drag-handle" style="color: #667eea; cursor: move;">
                                <i class="fas fa-arrows-alt"></i>
                            </div>
                        ` : ''}
                        <div class="item-media" style="width: 80px; height: 60px; border-radius: 6px; overflow: hidden; flex-shrink: 0;">
                            ${service.media_type === 'image' ? 
                                `<img src="${service.media_url}" alt="${service.title}" style="width: 100%; height: 100%; object-fit: cover;">` : 
                                `<video src="${service.media_url}" style="width: 100%; height: 100%; object-fit: cover;" muted></video>`
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
                                • Order: ${service.order}
                            </div>
                        </div>
                        <div class="item-actions" style="display: flex; gap: 8px; flex-shrink: 0;">
                            <button class="btn btn-info btn-sm" onclick="editService(${service.id})" style="padding: 6px 12px; font-size: 0.8rem;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-${service.is_active ? 'warning' : 'success'} btn-sm" onclick="toggleServiceStatus(${service.id})" style="padding: 6px 12px; font-size: 0.8rem;">
                                <i class="fas fa-${service.is_active ? 'eye-slash' : 'eye'}"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteService(${service.id})" style="padding: 6px 12px; font-size: 0.8rem;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;

        if (isReorderMode) {
            initializeSortable();
        }
    }

    // Toggle reorder mode
    function toggleReorderMode() {
        isReorderMode = !isReorderMode;
        loadServices(); // Reload to update UI
    }

    // Initialize sortable functionality
    function initializeSortable() {
        const sortable = document.getElementById('servicesSortable');
        if (!sortable) return;

        let draggedItem = null;

        sortable.querySelectorAll('.item-card').forEach(item => {
            item.setAttribute('draggable', true);
            
            item.addEventListener('dragstart', function(e) {
                draggedItem = this;
                setTimeout(() => this.style.opacity = '0.5', 0);
            });
            
            item.addEventListener('dragend', function() {
                this.style.opacity = '1';
                draggedItem = null;
            });
            
            item.addEventListener('dragover', function(e) {
                e.preventDefault();
            });
            
            item.addEventListener('drop', function(e) {
                e.preventDefault();
                if (draggedItem && draggedItem !== this) {
                    const allItems = Array.from(sortable.querySelectorAll('.item-card'));
                    const fromIndex = allItems.indexOf(draggedItem);
                    const toIndex = allItems.indexOf(this);
                    
                    if (fromIndex < toIndex) {
                        this.parentNode.insertBefore(draggedItem, this.nextSibling);
                    } else {
                        this.parentNode.insertBefore(draggedItem, this);
                    }
                    
                    updateOrderButton();
                }
            });
        });
    }

    // Update order button visibility
    function updateOrderButton() {
        const saveOrderBtn = document.getElementById('saveOrderBtn');
        saveOrderBtn.style.display = 'block';
    }

    // Save new order
    async function saveOrder() {
        const items = Array.from(document.querySelectorAll('#servicesSortable .item-card'));
        const serviceIds = items.map(item => item.getAttribute('data-id'));
        
        try {
            const response = await fetch('/admin/services/reorder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ services: serviceIds })
            });
            
            const result = await response.json();
            
            if (result.success) {
                showMessage(result.message, 'success');
                document.getElementById('saveOrderBtn').style.display = 'none';
                isReorderMode = false;
                loadServices();
            } else {
                showMessage(result.message, 'error');
            }
        } catch (error) {
            console.error('Error saving order:', error);
            showMessage('Failed to save order', 'error');
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

        // Validation
        if (!title || !description || !price || !details) {
            showMessage('Please fill in all required fields', 'error');
            return;
        }

        if (features.length === 0) {
            showMessage('Please add at least one service feature', 'error');
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
                ? `/admin/services/${currentEditingService.id}`
                : '/admin/services';
            
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
                resetForm();
            } else {
                showMessage(result.message, 'error');
            }
        } catch (error) {
            console.error('Error saving service:', error);
            showMessage('Failed to save service', 'error');
        }
    }

    // Edit service
    async function editService(serviceId) {
        try {
            const response = await fetch('/admin/services');
            const services = await response.json();
            const service = services.find(s => s.id == serviceId);
            
            if (service) {
                currentEditingService = service;
                document.getElementById('serviceTitle').value = service.title;
                document.getElementById('serviceDescription').value = service.description;
                document.getElementById('servicePrice').value = service.price;
                document.getElementById('serviceDetails').value = service.details;
                document.getElementById('serviceActive').checked = service.is_active;
                document.getElementById('formTitle').textContent = 'Edit Service';
                document.getElementById('saveButtonText').textContent = 'Update Service';
                document.getElementById('cancelButton').style.display = 'block';
                
                // Load features
                const featuresContainer = document.getElementById('serviceFeatures');
                const features = JSON.parse(service.features);
                featuresContainer.innerHTML = features.map(feature => `
                    <div class="feature-item" style="display: flex; align-items: center; gap: 10px; padding: 8px 12px; background: #f8f9fa; border-radius: 6px;">
                        <input type="text" class="feature-input form-control" value="${feature}" required>
                        <button type="button" class="remove-feature btn btn-danger btn-sm" onclick="removeFeature(this)">
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
                
                // Scroll to form
                document.querySelector('.content-card').scrollIntoView({ behavior: 'smooth' });
            }
        } catch (error) {
            console.error('Error loading service details:', error);
            showMessage('Failed to load service details', 'error');
        }
    }

    // Toggle service status
    async function toggleServiceStatus(serviceId) {
        try {
            const response = await fetch(`/admin/services/${serviceId}/toggle`, {
                method: 'POST',
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
            console.error('Error toggling service status:', error);
            showMessage('Failed to update service status', 'error');
        }
    }

    // Delete service
    async function deleteService(serviceId) {
        if (!confirm('Are you sure you want to delete this service?')) return;

        try {
            const response = await fetch(`/admin/services/${serviceId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            const result = await response.json();

            if (result.success) {
                showMessage(result.message, 'success');
                loadServices();
                if (currentEditingService && currentEditingService.id == serviceId) {
                    resetForm();
                }
            } else {
                showMessage(result.message, 'error');
            }
        } catch (error) {
            console.error('Error deleting service:', error);
            showMessage('Failed to delete service', 'error');
        }
    }

    // Feature management
    function addFeature() {
        const featuresContainer = document.getElementById('serviceFeatures');
        const newFeature = document.createElement('div');
        newFeature.className = 'feature-item';
        newFeature.style.cssText = 'display: flex; align-items: center; gap: 10px; padding: 8px 12px; background: #f8f9fa; border-radius: 6px;';
        newFeature.innerHTML = `
            <input type="text" class="feature-input form-control" placeholder="Enter feature" required>
            <button type="button" class="remove-feature btn btn-danger btn-sm" onclick="removeFeature(this)">
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

    // Reset form
    function resetForm() {
        currentEditingService = null;
        document.getElementById('serviceTitle').value = '';
        document.getElementById('serviceDescription').value = '';
        document.getElementById('servicePrice').value = '';
        document.getElementById('serviceDetails').value = '';
        document.getElementById('serviceActive').checked = true;
        document.getElementById('serviceFileInput').value = '';
        document.getElementById('serviceFilePreview').style.display = 'none';
        document.getElementById('serviceFilePreview').innerHTML = '';
        document.getElementById('formTitle').textContent = 'Add New Service';
        document.getElementById('saveButtonText').textContent = 'Save Service';
        document.getElementById('cancelButton').style.display = 'none';
        
        // Reset features
        const featuresContainer = document.getElementById('serviceFeatures');
        featuresContainer.innerHTML = `
            <div class="feature-item" style="display: flex; align-items: center; gap: 10px; padding: 8px 12px; background: #f8f9fa; border-radius: 6px;">
                <input type="text" class="feature-input form-control" placeholder="Enter feature" required>
                <button type="button" class="remove-feature btn btn-danger btn-sm" onclick="removeFeature(this)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
    }

    // File upload setup
    function setupFileUpload() {
        const serviceUpload = document.getElementById('serviceUploadContainer');
        const serviceFileInput = document.getElementById('serviceFileInput');
        const servicePreview = document.getElementById('serviceFilePreview');

        // Click to upload
        serviceUpload.addEventListener('click', () => serviceFileInput.click());

        // Drag and drop
        serviceUpload.addEventListener('dragover', (e) => {
            e.preventDefault();
            serviceUpload.style.borderColor = '#667eea';
            serviceUpload.style.background = '#f0f4ff';
        });

        serviceUpload.addEventListener('dragleave', () => {
            serviceUpload.style.borderColor = '#ddd';
            serviceUpload.style.background = '#fafafa';
        });

        serviceUpload.addEventListener('drop', (e) => {
            e.preventDefault();
            serviceUpload.style.borderColor = '#ddd';
            serviceUpload.style.background = '#fafafa';
            if (e.dataTransfer.files.length) {
                serviceFileInput.files = e.dataTransfer.files;
                handleFileSelect(serviceFileInput, servicePreview);
            }
        });

        // File selection
        serviceFileInput.addEventListener('change', () => handleFileSelect(serviceFileInput, servicePreview));
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

        if (file.size > 10 * 1024 * 1024) {
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

        // Show first 2 services in preview
        const previewServices = activeServices.slice(0, 2);
        preview.innerHTML = `
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; width: 100%;">
                ${previewServices.map(service => `
                    <div style="background: white; border: 1px solid #e1e5e9; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <div style="height: 120px; background: #f8f9fa; position: relative;">
                            ${service.media_type === 'image' ? 
                                `<img src="${service.media_url}" style="width: 100%; height: 100%; object-fit: cover;" alt="${service.title}">` :
                                `<video src="${service.media_url}" style="width: 100%; height: 100%; object-fit: cover;" muted></video>`
                            }
                            <div style="position: absolute; top: 8px; right: 8px; background: rgba(0,0,0,0.7); color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem;">
                                ${service.media_type}
                            </div>
                        </div>
                        <div style="padding: 12px;">
                            <div style="font-weight: 600; font-size: 0.9rem; margin-bottom: 5px; color: #333;">${service.title}</div>
                            <div style="font-size: 0.8rem; color: #666; margin-bottom: 8px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${service.description}</div>
                            <div style="font-size: 0.9rem; color: #28a745; font-weight: 600;">${service.price}</div>
                        </div>
                    </div>
                `).join('')}
            </div>
            ${activeServices.length > 2 ? 
                `<div style="margin-top: 15px; text-align: center; color: #666;">
                    <small>+ ${activeServices.length - 2} more services</small>
                </div>` : ''
            }
        `;
    }

    // Utility functions
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

    function showLoading(containerId) {
        const container = document.getElementById(containerId);
        container.innerHTML = `
            <div class="text-center" style="padding: 40px;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading...</p>
            </div>
        `;
    }
</script>

<style>
.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-switch .toggle-slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

.toggle-switch input:checked + .toggle-slider {
    background-color: #667eea;
}

.toggle-switch input:checked + .toggle-slider:before {
    transform: translateX(26px);
}

.item-card:hover {
    background-color: #f8f9fa !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.drag-handle {
    transition: all 0.3s ease;
}

.drag-handle:hover {
    transform: scale(1.1);
}

.feature-item {
    transition: all 0.3s ease;
}

.feature-item:hover {
    background: #e9ecef !important;
}
</style>
@endsection