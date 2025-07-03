<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kas RT Digital</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #1e40af;
            --primary-light: #3b82f6;
            --success-green: #059669;
            --success-light: #10b981;
            --warning-orange: #d97706;
            --warning-light: #f59e0b;
            --danger-red: #dc2626;
            --danger-light: #ef4444;
            --info-cyan: #0891b2;
            --info-light: #06b6d4;
            --dark-slate: #1e293b;
            --light-slate: #64748b;
            --bg-main: #f8fafc;
            --bg-card: #ffffff;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --border-light: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg-main);
            color: var(--text-primary);
            line-height: 1.6;
            font-size: 14px;
        }

        .dashboard-container {
            min-height: 100vh;
            padding: 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .dashboard-content {
            max-width: 1400px;
            margin: 0 auto;
            background: var(--bg-main);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
        }

        .main-header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
            padding: 32px 40px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .main-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: 1;
        }

        .main-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            z-index: 1;
        }

        .header-content {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .header-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-title i {
            background: rgba(255, 255, 255, 0.2);
            padding: 12px;
            border-radius: var(--radius-md);
            font-size: 2rem;
        }

        .header-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 400;
        }

        .header-info {
            display: flex;
            align-items: center;
            gap: 32px;
            background: rgba(255, 255, 255, 0.15);
            padding: 16px 24px;
            border-radius: var(--radius-md);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .datetime-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .current-date, .current-time {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 6px 12px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-sm);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .current-date i, .current-time i {
            font-size: 1rem;
            opacity: 0.8;
        }

        /* Profile Container Styles */
        .profile-container {
            position: relative;
            margin-left: 16px;
        }

        .profile-avatar-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px 16px;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            user-select: none;
            text-decoration: none;
            color: inherit;
        }

        .profile-avatar-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            color: inherit;
            text-decoration: none;
        }

        .profile-avatar-btn:active {
            transform: translateY(0);
        }

        .profile-arrow {
            transition: transform 0.3s ease;
            opacity: 0.7;
        }

        .profile-avatar-btn:hover .profile-arrow {
            transform: translateX(4px);
            opacity: 1;
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .profile-name {
            font-size: 0.95rem;
            font-weight: 600;
            line-height: 1.2;
        }

        .profile-role {
            font-size: 0.8rem;
            opacity: 0.8;
            line-height: 1.2;
        }

        .profile-avatar-btn i {
            font-size: 0.8rem;
            opacity: 0.7;
            transition: transform 0.3s ease;
        }

        .profile-avatar-btn.active i {
            transform: rotate(180deg);
        }

        /* Dropdown Styles */
        .dropdown-content {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: white;
            border-radius: var(--radius-md);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid var(--border-light);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .dropdown-content.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--text-primary);
            text-decoration: none;
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--border-light);
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: var(--bg-hover);
            color: var(--primary-blue);
        }

        .dropdown-item i {
            font-size: 1rem;
            width: 16px;
            text-align: center;
        }

        .dropdown-item.logout {
            color: #ef4444;
        }

        .dropdown-item.logout:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        .dropdown-header {
            padding: 16px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dropdown-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .dropdown-user-info {
            flex: 1;
        }

        .dropdown-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.95rem;
            margin-bottom: 2px;
        }

        .dropdown-email {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border-light);
            margin: 8px 0;
        }

        .dropdown-arrow {
            transition: transform 0.3s ease;
        }

        .profile-avatar-btn.active .dropdown-arrow {
            transform: rotate(180deg);
        }

        .main-content {
            padding: 40px;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--border-light);
        }

        .section-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .section-header i {
            color: var(--primary-blue);
            font-size: 1.4rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: 28px;
            box-shadow: var(--shadow-md);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--border-light);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--card-color), var(--card-color-light));
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--card-color);
        }

        .stat-card.primary { --card-color: var(--primary-blue); --card-color-light: var(--primary-light); }
        .stat-card.success { --card-color: var(--success-green); --card-color-light: var(--success-light); }
        .stat-card.warning { --card-color: var(--warning-orange); --card-color-light: var(--warning-light); }
        .stat-card.info { --card-color: var(--info-cyan); --card-color-light: var(--info-light); }

        .stat-icon {
            width: 64px;
            height: 64px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            margin-bottom: 20px;
            background: linear-gradient(135deg, var(--card-color), var(--card-color-light));
        }

        .stat-label {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 16px;
            line-height: 1.2;
        }

        .stat-link {
            color: var(--card-color);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .stat-link:hover {
            color: var(--card-color-light);
            gap: 12px;
        }

        .progress-container {
            margin: 16px 0;
        }

        .progress-bar-custom {
            height: 10px;
            background: #e5e7eb;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--card-color), var(--card-color-light));
            border-radius: 20px;
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .progress-text {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 32px;
            margin-bottom: 40px;
        }

        .content-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-light);
            overflow: hidden;
        }

        .card-header {
            padding: 24px 28px;
            background: #f8fafc;
            border-bottom: 1px solid var(--border-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0;
        }

        .card-title i {
            color: var(--primary-blue);
        }

        .btn {
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.85rem;
            border: 1px solid;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8rem;
        }

        .btn-outline-primary {
            color: var(--primary-blue);
            border-color: var(--primary-blue);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary-blue);
            color: white;
        }

        .card-body {
            padding: 28px;
        }

        .transaction-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .transaction-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s ease;
        }

        .transaction-item:hover {
            background: #f8fafc;
            margin: 0 -28px;
            padding: 16px 28px;
        }

        .transaction-item:last-child {
            border-bottom: none;
        }

        .transaction-info h6 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .transaction-date {
            font-size: 0.8rem;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .transaction-amount {
            font-size: 1.1rem;
            font-weight: 700;
            text-align: right;
        }

        .amount-income {
            color: var(--success-green);
        }

        .amount-expense {
            color: var(--danger-red);
        }

        .chart-container {
            position: relative;
            height: 350px;
            padding: 20px 0;
        }

        .quick-actions {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: 32px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-light);
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 24px;
            margin-top: 24px;
        }

        .action-item {
            text-align: center;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 20px;
            border-radius: var(--radius-md);
        }

        .action-item:hover {
            transform: translateY(-6px);
            background: #f8fafc;
        }

        .action-icon {
            width: 80px;
            height: 80px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin: 0 auto 16px;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            background: linear-gradient(135deg, var(--action-color), var(--action-color-light));
        }

        .action-item:hover .action-icon {
            transform: scale(1.1);
            box-shadow: var(--shadow-lg);
        }

        .action-item.primary { --action-color: var(--primary-blue); --action-color-light: var(--primary-light); }
        .action-item.success { --action-color: var(--success-green); --action-color-light: var(--success-light); }
        .action-item.info { --action-color: var(--info-cyan); --action-color-light: var(--info-light); }
        .action-item.warning { --action-color: var(--warning-orange); --action-color-light: var(--warning-light); }
        .action-item.danger { --action-color: var(--danger-red); --action-color-light: var(--danger-light); }
        .action-item.dark { --action-color: var(--dark-slate); --action-color-light: var(--light-slate); }

        .action-label {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-primary);
            line-height: 1.4;
            margin: 0;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .empty-state p {
            font-size: 1.1rem;
            font-weight: 500;
        }

        .info-banner {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border: 1px solid #93c5fd;
            border-radius: var(--radius-md);
            padding: 20px 24px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            gap: 16px;
            color: #1e40af;
        }

        .info-banner i {
            font-size: 1.5rem;
            color: var(--primary-blue);
        }

        .info-banner .content {
            flex: 1;
        }

        .info-banner .title {
            font-weight: 700;
            margin-bottom: 4px;
        }

        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 16px;
            }

            .main-header {
                padding: 24px;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 24px;
            }

            .header-info {
                flex-direction: column;
                gap: 16px;
                text-align: center;
                width: 100%;
            }

            .datetime-info {
                flex-direction: column;
                gap: 8px;
                width: 100%;
            }

            .current-date, .current-time {
                justify-content: center;
                width: 100%;
                max-width: 200px;
                margin: 0 auto;
            }

            .profile-container {
                margin-left: 0;
                width: 100%;
                display: flex;
                justify-content: center;
            }

            .profile-avatar-btn {
                justify-content: center;
                width: auto;
                min-width: 220px;
            }

            .dropdown-content {
                right: 50%;
                transform: translateX(50%) translateY(-10px);
                min-width: 200px;
            }

            .dropdown-content.show {
                transform: translateX(50%) translateY(0);
            }

            .header-title {
                font-size: 2rem;
            }

            .main-content {
                padding: 24px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .actions-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }
            
            .card-body,
            .card-header {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .header-title {
                font-size: 1.6rem;
                flex-direction: column;
                gap: 12px;
            }
            
            .actions-grid {
                grid-template-columns: 1fr;
            }
            
            .action-icon {
                width: 70px;
                height: 70px;
                font-size: 1.6rem;
            }
        }

        /* Styling untuk Detail Iuran */
        .iuran-detail-section {
            margin: 30px 0;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .iuran-summary {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .summary-item {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .summary-item.success {
            background: #dcfce7;
            color: #166534;
        }

        .summary-item.danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .summary-item.info {
            background: #dbeafe;
            color: #1e40af;
        }

        .iuran-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .iuran-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: #f8fafc;
            border-radius: 12px;
            border-left: 4px solid #10b981;
            transition: all 0.3s ease;
        }

        .iuran-item:hover {
            background: #f1f5f9;
            transform: translateX(5px);
        }

        .iuran-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .warga-name {
            font-weight: 600;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .payment-date {
            color: #64748b;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .iuran-amount {
            text-align: right;
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: flex-end;
        }

        .amount-value {
            font-size: 1.2rem;
            font-weight: 700;
            color: #10b981;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .status-badge.success {
            background: #dcfce7;
            color: #166534;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .empty-state h4 {
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: #374151;
        }

        @media (max-width: 768px) {
            .iuran-summary {
                flex-direction: column;
                gap: 10px;
            }

            .iuran-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .iuran-amount {
                align-items: flex-start;
                text-align: left;
            }
        }


    </style>
</head>
<body>
    <!-- Header Utama -->
<div class="main-header">
    <div class="header-content">
        <!-- Judul Aplikasi -->
        <div class="app-info">
            <h1 class="header-title">
                <i class="fas fa-university"></i>
                <span>Kas RT Digital</span>
            </h1>
            <p class="header-subtitle">Sistem Manajemen Keuangan Rukun Tetangga Modern</p>
        </div>

        <!-- Navbar Info Section -->
        <div class="header-info">
            <!-- Date & Time Info -->
            <div class="datetime-info">
                <div class="current-date">
                    <i class="fas fa-calendar-alt"></i>
                    <span id="currentDate">--/--/----</span>
                </div>

                <div class="current-time">
                    <i class="fas fa-clock"></i>
                    <span id="timeDisplay">--:--:--</span>
                </div>
            </div>

            <!-- Profile Section -->
            <div class="profile-container">
                <a href="<?= base_url('profile') ?>" class="profile-avatar-btn" id="profileLink">
                    <div class="profile-avatar">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="profile-info">
                        <div class="profile-name">Admin RT</div>
                        <div class="profile-role">Administrator</div>
                    </div>
                    <i class="fas fa-arrow-right profile-arrow"></i>
                </a>

                <!-- Dropdown Menu (Hidden for now) -->
                <div class="dropdown-content" id="dropdownMenu" style="display: none;">
                    <div class="dropdown-header">
                        <div class="dropdown-avatar">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="dropdown-user-info">
                            <div class="dropdown-name">Admin RT</div>
                            <div class="dropdown-email">admin@rt.local</div>
                        </div>
                    </div>

                    <div class="dropdown-divider"></div>

                    <a href="<?= base_url('profile') ?>" class="dropdown-item">
                        <i class="fas fa-user-cog"></i>
                        <span>Pengaturan Profil</span>
                    </a>

                    <a href="<?= base_url('/laporan/buat') ?>" class="dropdown-item">
                        <i class="fas fa-chart-bar"></i>
                        <span>Buat Laporan</span>
                    </a>

                    <a href="<?= base_url('/pengeluaran/catat') ?>" class="dropdown-item">
                        <i class="fas fa-money-bill-trend-down"></i>
                        <span>Catat Pengeluaran</span>
                    </a>

                    <div class="dropdown-divider"></div>

                    <a href="<?= base_url('/logout') ?>" class="dropdown-item logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar Sistem</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

           <!-- File: app/Views/dashboard.php -->
<!-- Konten Utama -->
<div class="main-content">
    <!-- Info Banner -->
    <div class="info-banner">
        <i class="fas fa-bullhorn"></i>
        <div class="content">
            <div class="title">Pengumuman Penting</div>
            <div>Rapat RT Bulan ini akan diadakan pada tanggal 10 Juli 2025. Mohon kehadiran seluruh warga!</div>
        </div>
    </div>

    <!-- Statistik Ringkasan -->
    <div class="section-header">
        <i class="fas fa-chart-line"></i>
        <h2>Ringkasan Keuangan RT</h2>
    </div>

    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-label">Total Warga Terdaftar</div>
            <div class="stat-value"><?= $jumlahWarga  ?></div>
            <a href="<?= base_url('/warga') ?>" class="stat-link">
                Kelola Data Warga <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="stat-card success">
            <div class="stat-icon">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stat-label">Saldo Kas Saat Ini</div>
            <div class="stat-value">Rp <?= number_format($saldoKas, 0, ',', '.') ?></div>
            <a href="<?= base_url('/transaksi/riwayat') ?>" class="stat-link">
                Lihat Riwayat Transaksi <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="stat-card info">
            <div class="stat-icon">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div class="stat-label">Iuran Terkumpul <?= $namaBulanSekarang ?> <?= $tahunSekarang ?></div>
            <div class="stat-value">Rp <?= number_format($iuranBulanIni, 0, ',', '.') ?></div>
            <div class="progress-container">
                <div class="progress-bar-custom">
                    <?php
                        $persentase = ($jumlahWarga  > 0) ? round(($totalPembayar / $jumlahWarga ) * 100, 1) : 0;
                    ?>
                    <div class="progress-fill" style="width: <?= $persentase ?>%"></div>
                </div>
                <div class="progress-text">
                    <?= $totalPembayar ?> dari <?= $jumlahWarga ?> warga (<?= $persentase ?>%)
                </div>
            </div>
            <a href="#iuran-detail" class="stat-link" onclick="toggleIuranDetail()">
                Lihat Detail Pembayaran <i class="fas fa-arrow-down" id="iuran-arrow"></i>
            </a>
        </div>

        <div class="stat-card warning">
            <div class="stat-icon">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div class="stat-label">Transaksi Bulan Ini</div>
            <div class="stat-value">
                <?= count($transaksiTerbaru) ?>
            </div>
            <a href="<?= base_url('/transaksi') ?>" class="stat-link">
                Lihat Detail Transaksi <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Detail Iuran Bulan Ini -->
    <div id="iuran-detail" class="iuran-detail-section" style="display: none;">
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-money-bill-wave"></i>
                    Detail Pembayaran Iuran <?= $namaBulanSekarang ?> <?= $tahunSekarang ?>
                </h3>
                <div class="iuran-summary">
                    <span class="summary-item success">
                        <i class="fas fa-check-circle"></i>
                        <?= $totalPembayar ?> Lunas
                    </span>
                    <span class="summary-item danger">
                        <i class="fas fa-times-circle"></i>
                        <?= $jumlahWarga - $totalPembayar ?> Belum Bayar
                    </span>
                    <span class="summary-item info">
                        <i class="fas fa-coins"></i>
                        Total: Rp <?= number_format($iuranBulanIni, 0, ',', '.') ?>
                    </span>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($pembayaranBulanIni)): ?>
                    <div class="iuran-list">
                        <?php foreach ($pembayaranBulanIni as $pembayaran): ?>
                            <div class="iuran-item">
                                <div class="iuran-info">
                                    <div class="warga-name">
                                        <i class="fas fa-user"></i>
                                        <?= esc($pembayaran['nama_warga'] ?? 'Unknown') ?>
                                    </div>
                                    <div class="payment-date">
                                        <i class="fas fa-calendar"></i>
                                        <?php if ($pembayaran['tanggal']): ?>
                                            <?= date('d M Y, H:i', strtotime($pembayaran['tanggal'])) ?>
                                        <?php else: ?>
                                            Tanggal tidak tersedia
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="iuran-amount">
                                    <div class="amount-value">
                                        Rp <?= number_format($pembayaran['nominal'], 0, ',', '.') ?>
                                    </div>
                                    <div class="status-badge success">
                                        <i class="fas fa-check"></i>
                                        Lunas
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h4>Belum Ada Pembayaran</h4>
                        <p>Belum ada warga yang membayar iuran bulan <?= $namaBulanSekarang ?> <?= $tahunSekarang ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Konten Transaksi dan Grafik -->
    <div class="content-grid">
        <!-- Transaksi Terbaru -->
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history"></i>
                    Transaksi Terbaru
                </h3>
                <a href="<?= base_url('/transaksi/riwayat') ?>" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-external-link-alt"></i>
                    Lihat Semua
                </a>
            </div>
            <div class="card-body">
                <div class="transaction-list">
                    <?php foreach ($transaksiTerbaru as $item): ?>
                        <div class="transaction-item">
                            <div class="transaction-info">
                                <h6>
                                    <?php if ($item['jenis'] === 'masuk'): ?>
                                        <i class="fas fa-arrow-down" style="color: #10b981; margin-right: 6px;"></i>
                                    <?php else: ?>
                                        <i class="fas fa-arrow-up" style="color: #ef4444; margin-right: 6px;"></i>
                                    <?php endif; ?>
                                    <?= isset($item['keterangan']) ? $item['keterangan'] : 'Transaksi' ?>

                                    <?php if ($item['jenis'] === 'keluar'): ?>
                                        <span class="transaction-type" style="background: #fee2e2; color: #991b1b; padding: 2px 8px; border-radius: 12px; font-size: 0.7rem; margin-left: 8px;">
                                            <i class="fas fa-minus-circle"></i> PENGELUARAN
                                        </span>
                                    <?php else: ?>
                                        <span class="transaction-type" style="background: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 12px; font-size: 0.7rem; margin-left: 8px;">
                                            <i class="fas fa-plus-circle"></i> PEMASUKAN
                                        </span>
                                    <?php endif; ?>
                                </h6>
                                <div class="transaction-date">
                                    <i class="fas fa-calendar-day"></i>
                                    <?php
                                    // Set timezone untuk konsistensi
                                    date_default_timezone_set('Asia/Jakarta');
                                    $tanggal = strtotime($item['tanggal']);
                                    $tanggalFormat = date('d M Y', $tanggal);
                                    $jamFormat = date('H:i:s', $tanggal);

                                    // Hitung selisih waktu
                                    $sekarang = time();
                                    $selisih = $sekarang - $tanggal;

                                    if ($selisih < 60) {
                                        $waktuRelative = 'Baru saja';
                                    } elseif ($selisih < 3600) {
                                        $waktuRelative = floor($selisih / 60) . ' menit yang lalu';
                                    } elseif ($selisih < 86400) {
                                        $waktuRelative = floor($selisih / 3600) . ' jam yang lalu';
                                    } else {
                                        $waktuRelative = floor($selisih / 86400) . ' hari yang lalu';
                                    }
                                    ?>
                                    <?= $tanggalFormat ?>
                                    <span style="color: #64748b; font-weight: 500;">
                                        <i class="fas fa-clock" style="margin-left: 8px; margin-right: 4px;"></i>
                                        <?= $jamFormat ?>
                                    </span>
                                    <br>
                                    <small style="color: #9ca3af; font-style: italic;">
                                        <i class="fas fa-history" style="margin-right: 4px;"></i>
                                        <?= $waktuRelative ?>
                                    </small>
                                </div>
                            </div>
                            <div class="transaction-amount <?= $item['jenis'] === 'masuk' ? 'amount-income' : 'amount-expense' ?>">
                                <div style="font-size: 1.1rem; font-weight: 700;">
                                    <?= ($item['jenis'] === 'masuk' ? '+' : '-') . ' Rp ' . number_format($item['jumlah'], 0, ',', '.') ?>
                                </div>
                                <small style="font-size: 0.8rem; opacity: 0.8;">
                                    <?= $item['jenis'] === 'masuk' ? 'Pemasukan' : 'Pengeluaran' ?>
                                </small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Grafik Statistik -->
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line"></i>
                    Statistik Iuran Bulan Ini
                </h3>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="iuranChart"></canvas>
                </div>


            </div>
        </div>
    </div>
</div>


                <!-- Menu Akses Cepat -->
                <div class="section-header">
                    <i class="fas fa-bolt"></i>
                    <h2>Menu Akses Cepat</h2>
                </div>

                <div class="quick-actions">
                    <div class="actions-grid">
                        <a href="<?= base_url('transaksi/tambah') ?>" class="action-item primary">
    <div class="action-icon">
        <i class="fas fa-plus"></i>
    </div>
    <p class="action-label">Tambah<br>Transaksi</p>
</a>

                        <a href="<?= base_url('iuran/bayar') ?>" class="action-item primary">
                            <div class="action-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <p class="action-label">Bayar<br>Iuran</p>
                        </a>

                        <a href="<?= base_url('warga/tambah') ?>" class="action-item primary">
                            <div class="action-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <p class="action-label">Tambah<br>Warga</p>
                        </a>

                        <a href="<?= base_url('laporan/buat') ?>" class="action-item primary">
                            <div class="action-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <p class="action-label">Buat<br>Laporan</p>
                        </a>

                        <a href="<?= base_url('pengeluaran/catat') ?>" class="action-item primary">
                            <div class="action-icon">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <p class="action-label">Catat<br>Pengeluaran</p>
                        </a>

                        <a href="<?= base_url('pengguna/profil') ?>" class="action-item primary">
                            <div class="action-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <p class="action-label">Login<br>Pengguna</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js"></script>
    <script>
        // Update waktu real-time
        function updateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            
            const dateStr = now.toLocaleDateString('id-ID', options);
            const timeStr = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            document.getElementById('currentDate').textContent = dateStr;
            document.getElementById('timeDisplay').textContent = timeStr;
        }

        // Jalankan fungsi update waktu
        updateTime();
        setInterval(updateTime, 1000);

                // Inisialisasi Chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('iuranChart').getContext('2d');

            // Data dari controller PHP
            const chartData = <?= json_encode($dataChartIuran) ?>;
            const dataIuran = chartData.data;
            const labelsChart = chartData.labels;
            const bulanChart = chartData.bulan;
            const tahunChart = chartData.tahun;

            // Hitung target harian berdasarkan jumlah warga (asumsi Rp 50.000 per warga per bulan)
            const targetBulanan = <?= $jumlahWarga ?> * 50000;
            const jumlahHari = labelsChart.length;
            const targetHarian = targetBulanan / jumlahHari;
            const targetData = Array(jumlahHari).fill(targetHarian);

            const iuranChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labelsChart,
                    datasets: [{
                        label: `Iuran Terkumpul ${bulanChart} ${tahunChart}`,
                        data: dataIuran,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        pointRadius: 6,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 3,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#059669',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }, {
                        label: 'Target Harian',
                        data: targetData,
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.05)',
                        borderWidth: 2,
                        borderDash: [8, 4],
                        pointRadius: 4,
                        pointBackgroundColor: '#ef4444',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 6,
                        fill: false,
                        tension: 0.2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'center',
                            labels: {
                                boxWidth: 12,
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: {
                                    size: 13,
                                    weight: '500'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#e2e8f0',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: true,
                            callbacks: {
                                title: function(context) {
                                    return 'Tanggal ' + context[0].label + ' ' + bulanChart + ' ' + tahunChart;
                                },
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', {
                                            style: 'currency',
                                            currency: 'IDR',
                                            maximumFractionDigits: 0
                                        }).format(context.parsed.y);
                                    }
                                    return label;
                                },
                                afterBody: function(context) {
                                    if (context.length > 1) {
                                        const actual = context[0].parsed.y;
                                        const target = context[1].parsed.y;
                                        const percentage = target > 0 ? ((actual / target) * 100).toFixed(1) : 0;
                                        return `Pencapaian: ${percentage}% dari target`;
                                    }
                                    return '';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: '#f1f5f9',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#64748b',
                                font: {
                                    size: 12,
                                    weight: '500'
                                }
                            },
                            title: {
                                display: true,
                                text: `Tanggal (${bulanChart} ${tahunChart})`,
                                color: '#374151',
                                font: {
                                    size: 13,
                                    weight: '600'
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#64748b',
                                font: {
                                    size: 12,
                                    weight: '500'
                                },
                                callback: function(value) {
                                    if (value >= 1000000) {
                                        return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                                    } else if (value >= 1000) {
                                        return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                                    }
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            },
                            title: {
                                display: true,
                                text: 'Jumlah Iuran (Rupiah)',
                                color: '#374151',
                                font: {
                                    size: 13,
                                    weight: '600'
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    elements: {
                        line: {
                            borderJoinStyle: 'round',
                            borderCapStyle: 'round'
                        },
                        point: {
                            hoverBorderWidth: 3
                        }
                    }
                }
            });
        });

        // Function untuk toggle detail iuran
        function toggleIuranDetail() {
            const detailSection = document.getElementById('iuran-detail');
            const arrow = document.getElementById('iuran-arrow');

            if (detailSection.style.display === 'none' || detailSection.style.display === '') {
                detailSection.style.display = 'block';
                arrow.className = 'fas fa-arrow-up';
            } else {
                detailSection.style.display = 'none';
                arrow.className = 'fas fa-arrow-down';
            }
        }

        // Profile link functionality (no dropdown needed)
        document.addEventListener('DOMContentLoaded', function() {
            const profileLink = document.getElementById('profileLink');

            if (profileLink) {
                // Add click effect
                profileLink.addEventListener('click', function(e) {
                    // Add a small delay for visual feedback
                    this.style.transform = 'translateY(0)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            }
        });
    </script>
</body>
</html>
