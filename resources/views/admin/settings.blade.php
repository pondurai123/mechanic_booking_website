@section('title', 'Settings')

@section('content')
<div class="header">
    <h1><i class="fas fa-cog"></i> Settings</h1>
    <p>Configure your system settings</p>
</div>

<div class="content-card">
    <div class="card-header">
        <h3><i class="fas fa-wrench"></i> System Configuration</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <div>
                    <h4 style="margin-bottom: 20px; color: #667eea;">
                        <i class="fas fa-user-shield"></i> Admin Information
                    </h4>
                    
                    <div class="form-group">
                        <label for="admin_email">Admin Email Address</label>
                        <input type="email" name="admin_email" id="admin_email" class="form-control" 
                               value="{{ $adminEmail }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="admin_contact">Admin Contact Number</label>
                        <input type="text" name="admin_contact" id="admin_contact" class="form-control" 
                               value="{{ $adminContact }}" required>
                    </div>
                </div>
                
                <div>
                    <h4 style="margin-bottom: 20px; color: #764ba2;">
                        <i class="fas fa-envelope"></i> Email SMTP Settings
                    </h4>
                    
                    <div class="form-group">
                        <label for="smtp_host">SMTP Host</label>
                        <input type="text" name="smtp_host" id="smtp_host" class="form-control" 
                               value="{{ $smtpHost }}" placeholder="smtp.gmail.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="smtp_port">SMTP Port</label>
                        <input type="number" name="smtp_port" id="smtp_port" class="form-control" 
                               value="{{ $smtpPort }}" placeholder="587" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="smtp_username">SMTP Username</label>
                        <input type="text" name="smtp_username" id="smtp_username" class="form-control" 
                               value="{{ $smtpUsername }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="smtp_password">SMTP Password</label>
                        <input type="password" name="smtp_password" id="smtp_password" class="form-control" 
                               value="{{ $smtpPassword }}" required>
                    </div>
                </div>
            </div>
            
            <div style="margin-top: 30px; text-align: center;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 1.1rem;">
                    <i class="fas fa-save"></i> Update Settings
                </button>
            </div>
        </form>
    </div>
</div>

<div class="content-card" style="margin-top: 30px;">
    <div class="card-header">
        <h3><i class="fas fa-info-circle"></i> Configuration Help</h3>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            <div>
                <h5 style="color: #667eea; margin-bottom: 15px;">Gmail SMTP Settings</h5>
                <ul style="margin: 0; padding-left: 20px; line-height: 1.8;">
                    <li><strong>Host:</strong> smtp.gmail.com</li>
                    <li><strong>Port:</strong> 587</li>
                    <li><strong>Username:</strong> your-email@gmail.com</li>
                    <li><strong>Password:</strong> App Password (not regular password)</li>
                </ul>
            </div>
            <div>
                <h5 style="color: #764ba2; margin-bottom: 15px;">Other SMTP Providers</h5>
                <ul style="margin: 0; padding-left: 20px; line-height: 1.8;">
                    <li><strong>Outlook:</strong> smtp-mail.outlook.com:587</li>
                    <li><strong>Yahoo:</strong> smtp.mail.yahoo.com:587</li>
                    <li><strong>SendGrid:</strong> smtp.sendgrid.net:587</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection