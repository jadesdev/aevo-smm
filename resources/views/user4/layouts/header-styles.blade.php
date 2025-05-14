<style>
    
    .notification-bell {
        position: relative;
        font-size: 20px;
        color: #fefefe;
    }
    .notification-bell i {
        font-size: 20px;
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

    .notify-item:last-child {
        border-bottom: none;
    }

    .fs-14 {
        font-size: 0.875rem !important;
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

    .notify-dropdown {
        background-color: #1f1f37;
        border: none !important;
        color: #f1f1f1;
    }

    .notify-dropdown .dropdown-item {
        color: #f1f1f1;
    }

    .notify-dropdown .dropdown-item:hover {
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
        color: #e9ecef;
        border-radius: 10px;
        box-shadow: none;
        border: 1px solid #a6a6a682;
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
</style>
