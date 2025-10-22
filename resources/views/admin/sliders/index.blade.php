@extends('layouts.admin')

@section('title', 'Slider Management')

@section('content')
<div class="header">
    <h1><i class="fas fa-sliders-h"></i> Slider Management</h1>
    <p>Manage hero slider content and order</p>
</div>

<!-- Success/Error Messages -->
<div id="successMessage" class="alert alert-success" style="display: none;"></div>
<div id="errorMessage" class="alert alert-danger" style="display: none;"></div>

<div class="content-management" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
    <!-- Add/Edit Slider Form -->
    <div class="content-card">
        <div class="card-header">
            <h3><i class="fas fa-plus-circle"></i> <span id="formTitle">Add New Slide</span></h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Slide Media</label>
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
                <label for="slideTitle">Slide Title *</label>
                <input type="text" class="form-control" id="slideTitle" placeholder="Enter slide title" required>
            </div>

            <div class="form-group">
                <label for="slideDescription">Slide Description</label>
                <textarea class="form-control" id="slideDescription" placeholder="Enter slide description" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label class="toggle-switch" style="position: relative; display: inline-block; width: 50px; height: 24px;">
                    <input type="checkbox" id="slideActive" checked>
                    <span class="toggle-slider" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 24px;"></span>
                </label>
                <span style="margin-left: 10px;">Active Slide</span>
            </div>

            <div class="form-actions" style="display: flex; gap: 10px;">
                <button class="btn btn-success" onclick="saveSlide()" style="flex: 1;">
                    <i class="fas fa-save"></i> <span id="saveButtonText">Save Slide</span>
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
            <div id="sliderPreview" style="border: 2px dashed #ddd; border-radius: 10px; padding: 20px; text-align: center; min-height: 300px; display: flex; align-items: center; justify-content: center;">
                <div style="color: #666;">
                    <i class="fas fa-sliders-h" style="font-size: 3rem; margin-bottom: 15px;"></i>
                    <p>Slider preview will appear here</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Slider List -->
<div class="content-card">
    <div class="card-header">
        <h3><i class="fas fa-list"></i> Current Slides (<span id="sliderCount">0</span>)</h3>
        <div style="display: flex; gap: 10px;">
            <button class="btn btn-info" onclick="loadSlides()">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
            <button class="btn btn-primary" onclick="saveOrder()" id="saveOrderBtn" style="display: none;">
                <i class="fas fa-save"></i> Save Order
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="items-list" id="sliderItems" style="min-height: 200px;">
            <div class="text-center" style="padding: 40px;">
                <div class="loading"></div>
                <p>Loading slides...</p>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 15px; width: 90%; max-width: 500px; max-height: 90%; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #eee;">
            <h3 style="margin: 0; color: #333;">
                <i class="fas fa-edit"></i> Edit Slide
            </h3>
            <button onclick="closeEditModal()" style="position: absolute; right: 15px; top: 15px; background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 20px;">
            <div id="editModalContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Global variables
    let currentEditingSlide = null;
    let isReorderMode = false;

    // CSRF token for AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Base URL for AJAX requests - dynamically get the base URL
        const baseUrl = '{{ url("/") }}';

    // Initialize the page
    document.addEventListener('DOMContentLoaded', function() {
        loadSlides();
        setupFileUpload();
    });

    // Load slides from backend
    async function loadSlides() {
        try {
            showLoading('sliderItems');
            const response = await fetch(`${baseUrl}/admin/sliders`, {
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

    // Display sliders in the list
    function displaySliders(sliders) {
        const container = document.getElementById('sliderItems');
        document.getElementById('sliderCount').textContent = sliders.length;
        
        if (sliders.length === 0) {
            container.innerHTML = `
                <div class="text-center" style="padding: 40px; color: #666;">
                    <i class="fas fa-images" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;"></i>
                    <p>No slides added yet</p>
                    <button class="btn btn-primary" onclick="resetForm()">
                        <i class="fas fa-plus"></i> Add Your First Slide
                    </button>
                </div>
            `;
            return;
        }

        container.innerHTML = `
            <div style="margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <strong>Drag to reorder slides</strong>
                    <small style="color: #666; margin-left: 10px;">The first active slide will be shown on the homepage</small>
                </div>
                <button class="btn btn-sm ${isReorderMode ? 'btn-success' : 'btn-outline-primary'}" onclick="toggleReorderMode()">
                    <i class="fas fa-arrows-alt"></i> ${isReorderMode ? 'Save Order' : 'Reorder'}
                </button>
            </div>
            <div id="slidersSortable" style="display: grid; gap: 10px;">
                ${sliders.map(slider => `
                    <div class="item-card" data-id="${slider.id}" style="padding: 15px; border: 1px solid #e1e5e9; border-radius: 8px; background: white; display: flex; align-items: center; gap: 15px; transition: all 0.3s ease; cursor: ${isReorderMode ? 'move' : 'default'};">
                        ${isReorderMode ? `
                            <div class="drag-handle" style="color: #667eea; cursor: move;">
                                <i class="fas fa-arrows-alt"></i>
                            </div>
                        ` : ''}
                        <div class="item-media" style="width: 80px; height: 60px; border-radius: 6px; overflow: hidden; flex-shrink: 0;">
                            ${slider.media_type === 'image' ? 
                                `<img src="${slider.media_url}" alt="${slider.title}" style="width: 100%; height: 100%; object-fit: cover;">` : 
                                `<video src="${slider.media_url}" style="width: 100%; height: 100%; object-fit: cover;" muted></video>`
                            }
                        </div>
                        <div class="item-content" style="flex: 1; min-width: 0;">
                            <div class="item-title" style="font-weight: 600; color: #333; margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${slider.title}</div>
                            <div class="item-meta" style="font-size: 0.8rem; color: #666;">
                                <span class="media-badge ${slider.media_type === 'image' ? 'badge-image' : 'badge-video'}" style="display: inline-block; padding: 3px 8px; border-radius: 12px; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; background: ${slider.media_type === 'image' ? '#e3f2fd' : '#fff3e0'}; color: ${slider.media_type === 'image' ? '#1976d2' : '#f57c00'};">
                                    ${slider.media_type}
                                </span>
                                ${slider.is_active ? '<span style="color: #28a745;">• Active</span>' : '<span style="color: #dc3545;">• Inactive</span>'}
                                • Order: ${slider.order}
                            </div>
                        </div>
                        <div class="item-actions" style="display: flex; gap: 8px; flex-shrink: 0;">
                            <button class="btn btn-info btn-sm" onclick="editSlide(${slider.id})" style="padding: 6px 12px; font-size: 0.8rem;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-${slider.is_active ? 'warning' : 'success'} btn-sm" onclick="toggleSlideStatus(${slider.id})" style="padding: 6px 12px; font-size: 0.8rem;">
                                <i class="fas fa-${slider.is_active ? 'eye-slash' : 'eye'}"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteSlide(${slider.id})" style="padding: 6px 12px; font-size: 0.8rem;">
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
        loadSlides(); // Reload to update UI
    }

    // Initialize sortable functionality
    function initializeSortable() {
        const sortable = document.getElementById('slidersSortable');
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
        const items = Array.from(document.querySelectorAll('#slidersSortable .item-card'));
        const sliderIds = items.map(item => item.getAttribute('data-id'));
        
        try {
            const response = await fetch('${baseUrl}/sliders/reorder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ sliders: sliderIds })
            });
            
            const result = await response.json();
            
            if (result.success) {
                showMessage(result.message, 'success');
                document.getElementById('saveOrderBtn').style.display = 'none';
                isReorderMode = false;
                loadSlides();
            } else {
                showMessage(result.message, 'error');
            }
        } catch (error) {
            console.error('Error saving order:', error);
            showMessage('Failed to save order', 'error');
        }
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
                ? `${baseUrl}/admin/sliders/${currentEditingSlide.id}`
                : `${baseUrl}/admin/sliders`;
            
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
                resetForm();
            } else {
                showMessage(result.message, 'error');
            }
        } catch (error) {
            console.error('Error saving slide:', error);
            showMessage('Failed to save slide', 'error');
        }
    }

    // Edit slide
    async function editSlide(slideId) {
        try {
            const response = await fetch(`${baseUrl}/admin/sliders`);
            const sliders = await response.json();
            const slide = sliders.find(s => s.id == slideId);
            
            if (slide) {
                currentEditingSlide = slide;
                document.getElementById('slideTitle').value = slide.title;
                document.getElementById('slideDescription').value = slide.description || '';
                document.getElementById('slideActive').checked = slide.is_active;
                document.getElementById('formTitle').textContent = 'Edit Slide';
                document.getElementById('saveButtonText').textContent = 'Update Slide';
                document.getElementById('cancelButton').style.display = 'block';
                
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
                
                // Scroll to form
                document.querySelector('.content-card').scrollIntoView({ behavior: 'smooth' });
            }
        } catch (error) {
            console.error('Error loading slide details:', error);
            showMessage('Failed to load slide details', 'error');
        }
    }

    // Toggle slide status
    async function toggleSlideStatus(slideId) {
        try {
            const response = await fetch(`${baseUrl}/sliders/${slideId}/toggle`, {
                method: 'POST',
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
            console.error('Error toggling slide status:', error);
            showMessage('Failed to update slide status', 'error');
        }
    }

    // Delete slide
    async function deleteSlide(slideId) {
        if (!confirm('Are you sure you want to delete this slide?')) return;

        try {
            const response = await fetch(`${baseUrl}/sliders/${slideId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            const result = await response.json();

            if (result.success) {
                showMessage(result.message, 'success');
                loadSlides();
                if (currentEditingSlide && currentEditingSlide.id == slideId) {
                    resetForm();
                }
            } else {
                showMessage(result.message, 'error');
            }
        } catch (error) {
            console.error('Error deleting slide:', error);
            showMessage('Failed to delete slide', 'error');
        }
    }

    // Reset form
    function resetForm() {
        currentEditingSlide = null;
        document.getElementById('slideTitle').value = '';
        document.getElementById('slideDescription').value = '';
        document.getElementById('slideActive').checked = true;
        document.getElementById('sliderFileInput').value = '';
        document.getElementById('sliderFilePreview').style.display = 'none';
        document.getElementById('sliderFilePreview').innerHTML = '';
        document.getElementById('formTitle').textContent = 'Add New Slide';
        document.getElementById('saveButtonText').textContent = 'Save Slide';
        document.getElementById('cancelButton').style.display = 'none';
    }

    // File upload setup
    function setupFileUpload() {
        const sliderUpload = document.getElementById('sliderUploadContainer');
        const sliderFileInput = document.getElementById('sliderFileInput');
        const sliderPreview = document.getElementById('sliderFilePreview');

        // Click to upload
        sliderUpload.addEventListener('click', () => sliderFileInput.click());

        // Drag and drop
        sliderUpload.addEventListener('dragover', (e) => {
            e.preventDefault();
            sliderUpload.style.borderColor = '#667eea';
            sliderUpload.style.background = '#f0f4ff';
        });

        sliderUpload.addEventListener('dragleave', () => {
            sliderUpload.style.borderColor = '#ddd';
            sliderUpload.style.background = '#fafafa';
        });

        sliderUpload.addEventListener('drop', (e) => {
            e.preventDefault();
            sliderUpload.style.borderColor = '#ddd';
            sliderUpload.style.background = '#fafafa';
            if (e.dataTransfer.files.length) {
                sliderFileInput.files = e.dataTransfer.files;
                handleFileSelect(sliderFileInput, sliderPreview);
            }
        });

        // File selection
        sliderFileInput.addEventListener('change', () => handleFileSelect(sliderFileInput, sliderPreview));
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
                <div style="position: relative; height: 250px; background: #f8f9fa; border-radius: 8px; overflow: hidden;">
                    ${activeSlides[0].media_type === 'image' ? 
                        `<img src="${activeSlides[0].media_url}" style="width: 100%; height: 100%; object-fit: cover;" alt="${activeSlides[0].title}">` :
                        `<video src="${activeSlides[0].media_url}" style="width: 100%; height: 100%; object-fit: cover;" autoplay muted loop></video>`
                    }
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.7); color: white; padding: 20px;">
                        <h4 style="margin: 0 0 8px 0; font-size: 1.3rem;">${activeSlides[0].title}</h4>
                        <p style="margin: 0; font-size: 1rem; opacity: 0.9;">${activeSlides[0].description}</p>
                    </div>
                </div>
                <div style="margin-top: 15px; text-align: center; color: #666;">
                    <small>Previewing 1 of ${activeSlides.length} active slides</small>
                </div>
            </div>
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

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
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
</style>
@endsection