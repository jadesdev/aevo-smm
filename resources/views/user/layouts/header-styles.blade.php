<style>
    .app-header {
        background-color: #ffffff;
        padding: 15px 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        position: sticky;
        top: 0;
        z-index: 1000;
    }


    .header-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* User area styling */
    .user-area {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .user-area .user-balance {
        font-size: 13px;
        color: #1a1a1a;
    }

    body.dark .user-balance {
        font-size: 13px;
        color: #fefefe;
    }

    .notification-bell {
        position: relative;
        font-size: 20px;
        color: #1a1a1a;
    }

    body.dark .notification-bell {
        font-size: 20px;
        color: #fefefe;
    }

    @media (max-width: 767.98px) {
        .user-area {
            gap: 15px;
        }

        .app-container .app-header .user-balance {
            color: #fefefe;
        }

        .notification-bell {
            color: #fefefe;
        }
    }

    .notification-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: #ff0000;
        color: white;
        font-size: 10px;
        font-weight: bold;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-image {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        cursor: pointer;
    }

    /* Dropdown styling */
    .user-profile .dropdown-menu {
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border: none;
        padding: 8px 0;
        margin-top: 10px;
        right: 0;
        left: auto !important;
        transform: none;
        overflow-y: hidden;
    }

    .user-profile .dropdown-item {
        padding: 10px 20px;
        font-size: 14px;
        color: #333;
        transition: background-color 0.2s;
    }

    .user-profile .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .user-profile .dropdown-divider {
        margin: 8px 0;
        border-top: 1px solid #e9ecef;
    }

    .notify-item {
        border-bottom: 1px solid #c6c8cb;
    }

    .notify-item:last-child {
        border-bottom: none;
    }

    .user-profile .dropdown-item i {
        width: 20px;
        text-align: center;
        color: #666;
    }

    .fs-14 {
        font-size: 0.875rem !important;
    }

    body.dark .user-profile .dropdown-menu {
        background-color: #1e1e1e;
        color: #f1f1f1;
    }

    body.dark .user-profile .dropdown-item {
        color: #f1f1f1;
    }

    body.dark .user-profile .dropdown-item:hover {
        background-color: #2c2c2c;
    }

    body.dark .user-profile .dropdown-item i {
        color: #bbb;
    }

    .noti-height {
        height: 350px;
    }


    .notification-dropdown .dropdown-menu {
        right: 20px;
        left: auto !important;
        z-index: 1900;
        position: absolute;
        max-height: none;
    }

    /* Notification dropdown styling */
    .notify-dropdown {
        top: 100%;
        right: 0;
        left: auto !important;
        width: 350px;
        padding-right: 0 !important;
        margin-top: 10px;
        padding: 10px 0;
        overflow-y: auto;
        z-index: 1900;
    }

    body.dark .notify-dropdown {
        background-color: #1e1e1e;
        color: #f1f1f1;
    }

    body.dark .notify-dropdown .dropdown-item {
        color: #f1f1f1;
    }

    .notify-dropdown .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    body.dark .notify-dropdown .dropdown-item:hover {
        background-color: #2c2c2c;
    }

    .card-notif p {
        font-size: 13px;
        padding: 0;
        margin-top: -3px;
    }

    .tima {
        font-size: 10px;
        margin-top: -13px;
    }

    .card-notif {
        padding: 16px 21px 16px 16px;
        cursor: pointer;
        margin: 6px;
        color: #333;
        border-radius: 10px;
        border: none;
        box-shadow: none;
    }

    body.dark .card-notif {
        color: #e9ecef;
    }

    @media only screen and (max-width: 1199.8px) {

        .notify-dropdown {
            width: 100%;
            right: 0 !important;
            transform: none !important;
        }
    }

    @media only screen and (max-width: 768px) {

        .notify-dropdown {
            width: 100%;
            transform: none !important;
        }

        .noti-height {
            height: 85dvh;
        }
    }

    @media (max-width: 576px) {
        .noti-height {
            height: 88dvh;
        }
    }

    .theme-mode {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    body .darkmode .dark-txt,
    body.light .darkmode .dark-txt {
        display: block
    }

    body .darkmode .light-txt,
    body.light .darkmode .light-txt {
        display: none
    }

    body.dark .darkmode .dark-txt {
        display: none
    }

    body.dark .darkmode .light-txt {
        display: block
    }
</style>
