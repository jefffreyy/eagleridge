<style>
    label{
        font-weight: 500 !important:
    }

    li a {
        color: #0D74BC;
    }

    a:hover {
        text-decoration: none;
    }

    .activity td {
        padding: 6.8px 20px;
    }

    .page-item .active {
        background-color: #0D74BC !important;
    }

    label.required:after {
        content: " *";
    }

    label.required:after {
        content: " *";
        color: red;
    }

    li a {
        font-size: 14px;
    }

    .header-elements a {
        font-size: 14px;
    }

    .list-icons a {
        font-size: 11.2px;
        color: #197fc7;
    }

    td {
        width: 100%;
    }

    .shortcuts{
        /* background-color: #23ace0; */
        background: rgb(36,86,184);
        background: linear-gradient(0deg, rgba(36,86,184,1) 2%, rgba(86,143,233,1) 86%);
        color: #fff;
        padding: 18px 5px 10px 5px;
        margin: auto;
        width: 90px;
        height: 90px;
        border-radius: 15px;
        margin: 10px;
    }

    .shortcuts:hover{
        transition: 0.3s;
        /* background-color: #2e7dd6; */
        opacity: 0.8;
        cursor: pointer;
    }

    .shortcut_container{
        /* padding-left: 100px;
        padding-right: 100px; */
        padding-left: 50px;
        padding-right: 50px;
    }

    .shortcuts i{
        font-size: 30px;
    }

    .shortcuts p{
        font-size:12px;
        margin-top: 8px;
        margin-bottom: 0px;
        line-height: 12px;
        height: 24px;
    }

    .announcements{
        padding: 18px 0px 10px !important;
    }

    .shortcuts .single_line_text{
        margin-top: 12px;
    }

    @media screen and (max-width: 1500px) {
        .shortcut_container{
            padding-left: 20px !important;
            padding-right: 20px !important;
        }

        .shortcuts{
            /* background-color: #23ace0; */
            background: rgb(36,86,184);
            background: linear-gradient(0deg, rgba(36,86,184,1) 2%, rgba(86,143,233,1) 86%);
            color: #fff;
            padding: 14px 5px 10px 5px;
            margin: auto;
            width: 80px;
            height: 80px;
            border-radius: 15px;
        }

        .shortcuts p{
            font-size:12px;
            margin-top: 5px;
            margin-bottom: 0px;
            line-height: 12px;
            height: 24px;
        }

        .announcements{
            padding: 14px 0px 10px !important;
            font-size: 11px;
        }
    }

    @media screen and (max-width: 500px) {
        .col-sm-2{
            width: 50% !important;
            margin-top: 10px;
        }

        #current_date{
            text-align: center;
            font-size: 20px !important;
        }

        #check_holiday{
            text-align: center;
        }

        #current_time{
            margin-top: 10px;
            font-size: 30px !important;
            font-weight: 500 !important:
        }

        #current_phase{
            margin-top: 15px !important;
        }

        .time_container{
            float: none !important;
            width: 100%;
            text-align: center !important;
            margin-left: auto;
            margin-right: auto;
        }

        .categories{
            text-align: center;
            margin-top: 10px;
        }

        .categories_header{
            text-align: center;
        }
    }
    
    
</style>