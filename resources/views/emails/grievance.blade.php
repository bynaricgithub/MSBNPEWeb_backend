<!DOCTYPE html>
<html>

<head>
    <title>Complaint Details</title>
    <style>
        /* Container */
        .custom-container {
            padding-right: 15px;
            padding-left: 15px;
            width: 40vw;
        }

        /* Card */
        .custom-card {
            margin-top: 3rem;
            /* Equivalent to my-5 */
            margin-bottom: 3rem;
            /* Equivalent to my-5 */
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
        }

        .custom-card-body {
            padding: 1.25rem;
        }

        /* Fade-in effect */
        .custom-fade-in-top {
            animation: fadeInTop 0.5s ease-out both;
        }

        @keyframes fadeInTop {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Row */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        /* Column */
        .col-half {
            position: relative;
            width: 100%;

        }

        /* Table */
        .custom-table {
            width: 100%;
            padding: 15px;
            color: #212529;
        }

        .custom-bordered {
            border: 1px solid #dee2e6;
        }


        /* Border */
        .custom-border {
            border: 1px solid #dee2e6 !important;
        }

        /* Text Muted */
        .custom-text-muted {
            color: #6c757d !important;
        }

        /* Image */
        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        /* Padding Y */
        .py-2 {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
        }
    </style>
</head>

<body>
    <div class="custom-container">
        <div class="custom-card">
            <div class="custom-card-body">
                <div class="custom-fade-in-top custom-padding row">
                    <div class="col-half">
                        <table class="custom-table custom-border custom-bordered">
                            <tbody>
                                <tr>
                                    <td><b>Complaint Id :</b></td>
                                    <td>{{ $data['complaint_id'] }}</td>
                                </tr>
                                @if ($data['categoryofComplainant'] == 'Student')
                                    <tr>
                                        <td><b>Complainant Name :</b></td>
                                        <td>{{ $data['studentName'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Mobile No. :</b></td>
                                        <td>{{ $data['studentMobile'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Email :</b></td>
                                        <td>{{ $data['studentEmail'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Address :</b></td>
                                        <td>
                                            {{ $data['studentAddressLine1'] }},
                                            {{ $data['studentAddressLine2'] }},
                                            {{ $data['studentTaluka'] }},
                                            {{ $data['studentDistrict'] }}-
                                            {{ $data['studentPinCode'] }}
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td><b>Complainant Name :</b></td>
                                        <td>{{ $data['complainantName'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Mobile No. :</b></td>
                                        <td>{{ $data['complainantMobile'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Email :</b></td>
                                        <td>{{ $data['complainantEmail'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Address :</b></td>
                                        <td>
                                            {{ $data['complainantAddressLine1'] }},
                                            {{ $data['complainantAddressLine2'] }},
                                            {{ $data['complainantTaluka'] }},
                                            {{ $data['complainantDistrict'] }}-
                                            {{ $data['complainantPinCode'] }}
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td><b>Admitted / Yet to be Admitted :</b></td>
                                    <td>{{ $data['isAdmitted'] }}</td>
                                </tr>
                                <tr>
                                    <td><b>Academic Year of Admission :</b></td>
                                    <td>{{ $data['AYYearofAdmission'] }}</td>
                                </tr>
                                <tr>
                                    <td><b>Complaint relating to Academic Year :</b></td>
                                    <td>{{ $data['AYYearofComplaint'] }}</td>
                                </tr>
                                <tr>
                                    <td><b>Admission Number / Student Roll Number :</b></td>
                                    <td>{{ $data['studentRollNo'] }}</td>
                                </tr>
                                <tr>
                                    <td><b>Course :</b></td>
                                    <td>{{ $data['course'] }}</td>
                                </tr>
                                <tr>
                                    <td><b>Year :</b></td>
                                    <td>{{ $data['studentYear'] }}</td>
                                </tr>
                                <tr>
                                    <td><b>Complaint Against :</b></td>
                                    <td>{{ $data['complaintAgainst'] }}</td>
                                </tr>
                                <tr>
                                    <td><b>Complaint Type :</b></td>
                                    <td>{{ $data['complaintType'] }}</td>
                                </tr>

                                @if ($data['complaintType'] == 'other')
                                    <tr>
                                        <td><b>Other Complaint type :</b></td>
                                        <td>{{ $data['complaintTypeOther'] }}</td>
                                    </tr>
                                @endif

                                <tr>
                                    <td><b>Name of College :</b></td>
                                    <td>{{ $data['college'] }}</td>
                                </tr>
                                <tr>
                                    <td><b>Address of College :</b></td>
                                    <td>
                                        {{ $data['course'] }}
                                        {{ $data['collegeAddressLine1'] }},
                                        {{ $data['collegeAddressLine2'] }},
                                        {{ $data['collegeTaluka'] }},
                                        {{ $data['collegeDistrict'] }} -
                                        {{ $data['collegePinCode'] }}
                                    </td>
                                </tr>

                                <tr>
                                    <td><b>Status :</b></td>
                                    <td>Pending</td>
                                </tr>
                                {{-- <tr>
                                    <td>Track here :</td>
                                    <td>
                                        <a href="http://localhost:3000/grievance/status/{{ $data[complaint_id] }}"
                                            target="_blank" rel="noopener noreferrer">Track Application</a>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                        <p>
                            You can track your Application using Complaint Id. Please go to Track Grievance Status.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
