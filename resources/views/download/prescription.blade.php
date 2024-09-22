<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>
<body >
    <div style="margin: 0; padding: 0;">
        <table cellpadding="0" cellspacing="0" style="width: 1277px; padding: 20px 15px; border: none; margin: 0 auto 60px;">
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" style="width:100%;">
                        <tr>
                            <td>
                                <div style="margin-bottom: 4px;">
                                    <h3 style="font-size: 28px; font-weight: bold; color: #313131; font-family: Nunito; line-height: 38.19px; margin: 0;">Prescription</h3>
                                </div>
                                <div style="border: 0.3px solid #313131; border-radius: 14px; position: relative; padding: 23px 0 0;">
                                    <div style="padding: 0 18px 37px;">
                                        <h4 style="font-size: 22px; font-weight: bold; margin: 0; margin-bottom: 28px; font-family: Nunito; line-height: 30.01px; color: #313131;">{{$patientInfo->name ?? ''}} - {{$patientInfo->mr_no ?? ''}}</h4>
                                            <img src="{{ public_path('assets/img/pdf-images/logo.png') }}" style="width: 190px; height: 40px; position: absolute; top: 23px; right: 31px;" />                                       
                                       <table style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="vertical-align: top;">
                                                    <div>
                                                        <h6 style="font-size: 16px; margin: 0; font-weight: normal; color: #313131; font-family: Circular Std; margin-bottom: 14px; line-height: 22.77px; color: #313131;">Age</h6>
                                                        <p style="font-size: 18px; margin: 0; font-weight: normal; line-height: 22.77px; font-family: Circular Std; color: #313131;">{{$patientInfo->age ?? ''}} years</p>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <div>
                                                        <h6 style="font-size: 16px; margin: 0; font-weight: normal; color: #313131; font-family: Circular Std; margin-bottom: 14px; line-height: 22.77px; color: #313131;">Gender</h6>
                                                        <p style="font-size: 18px; margin: 0; font-weight: normal; line-height: 22.77px; font-family: Circular Std; color: #313131;">{{$patientInfo->gender ?? ''}}</p>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <div>
                                                        <h6 style="font-size: 16px; margin: 0; font-weight: normal; color: #313131; font-family: Circular Std; margin-bottom: 14px; line-height: 22.77px; color: #313131;">Date Of Birth</h6>
                                                        <p style="font-size: 18px; margin: 0; font-weight: normal; line-height: 22.77px; font-family: Circular Std; color: #313131;">{{$patientInfo->date_of_birth ?? ''}}</p>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <div>
                                                        <h6 style="font-size: 16px; margin: 0; font-weight: normal; color: #313131; font-family: Circular Std; margin-bottom: 14px; line-height: 22.77px; color: #313131;">CNIC</h6>
                                                        <p style="font-size: 18px; margin: 0; font-weight: normal; line-height: 22.77px; font-family: Circular Std; color: #313131;">{{$patientInfo->cnic ?? ''}}</p>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <div>
                                                        <h6 style="font-size: 16px; margin: 0; font-weight: normal; color: #313131; font-family: Circular Std; margin-bottom: 14px; line-height: 22.77px; color: #313131;">Address</h6>
                                                        <p style="font-size: 18px; margin: 0; font-weight: normal; line-height: 22.77px; font-family: Circular Std; color: #313131;">{{$patientInfo->address ?? ''}}</p>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <div>
                                                        <h6 style="font-size: 16px; margin: 0; font-weight: normal; color: #313131; font-family: Circular Std; margin-bottom: 14px; line-height: 22.77px; color: #313131;">Ethnicity</h6>
                                                        <p style="font-size: 18px; margin: 0; font-weight: normal; line-height: 22.77px; font-family: Circular Std; color: #313131;">{{$patientInfo->ethnicity($patientInfo->ethnicity) ?? ''}}</p>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <div>
                                                        <h6 style="font-size: 16px; margin: 0; font-weight: normal; color: #313131; font-family: Circular Std; margin-bottom: 14px; line-height: 22.77px; color: #313131;">Follow Up</h6>
                                                        <p style="font-size: 18px; margin: 0; font-weight: normal; line-height: 22.77px; font-family: Circular Std; color: #313131;">{{$prescription[0]->appointment->follow_up_date}}</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <table style="margin-bottom: 0; width: 100%; border-collapse: collapse;">
                                        <thead>
                                        <tr>
                                            <th style="text-align: center; border: none; background-color: #F5F5F5; color: #313131; font-size: 18px; font-weight: bold; font-family: Circular Std; line-height: 25.3px; padding: 0.5rem .5rem;">Medicine</th>
                                            <th style="text-align: center; border: none; background-color: #F5F5F5; color: #313131; font-size: 18px; font-weight: bold; font-family: Circular Std; line-height: 25.3px; padding: 0.5rem .5rem;">Generic</th>
                                            <th style="text-align: center; border: none; background-color: #F5F5F5; color: #313131; font-size: 18px; font-weight: bold; font-family: Circular Std; line-height: 25.3px; padding: 0.5rem .5rem;">Type</th>
                                            <th style="text-align: center; border: none; background-color: #F5F5F5; color: #313131; font-size: 18px; font-weight: bold; font-family: Circular Std; line-height: 25.3px; padding: 0.5rem .5rem;">Route</th>
                                            <th style="text-align: center; border: none; background-color: #F5F5F5; color: #313131; font-size: 18px; font-weight: bold; font-family: Circular Std; line-height: 25.3px; padding: 0.5rem .5rem;">Item Strength</th>
                                            <th style="text-align: center; border: none; background-color: #F5F5F5; color: #313131; font-size: 18px; font-weight: bold; font-family: Circular Std; line-height: 25.3px; padding: 0.5rem .5rem;">Duration</th>
                                            <th style="text-align: center; border: none; background-color: #F5F5F5; color: #313131; font-size: 18px; font-weight: bold; font-family: Circular Std; line-height: 25.3px; padding: 0.5rem .5rem;">Frequency</th>
                                            <th style="text-align: center; border: none; background-color: #F5F5F5; color: #313131; font-size: 18px; font-weight: bold; font-family: Circular Std; line-height: 25.3px; padding: 0.5rem .5rem;">Instructions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td style="padding: 12px 11px; border-bottom: 1px solid #078A8E; padding: 19px 11px 18px; text-align: center; font-size: 16px; font-weight: normal; font-family: Circular Std; line-height: 22.77px; border-bottom: 1px solid rgb(222, 226, 230); color: #313131;"></td>
                                            <td style="padding: 12px 11px; border-bottom: 1px solid #078A8E; padding: 19px 11px 18px; text-align: center; font-size: 16px; font-weight: normal; font-family: Circular Std; line-height: 22.77px; border-bottom: 1px solid rgb(222, 226, 230); color: #313131;"></td>
                                            <td style="padding: 12px 11px; border-bottom: 1px solid #078A8E; padding: 19px 11px 18px; text-align: center; font-size: 16px; font-weight: normal; font-family: Circular Std; line-height: 22.77px; border-bottom: 1px solid rgb(222, 226, 230); color: #313131;"></td>
                                            <td style="padding: 12px 11px; border-bottom: 1px solid #078A8E; padding: 19px 11px 18px; text-align: center; font-size: 16px; font-weight: normal; font-family: Circular Std; line-height: 22.77px; border-bottom: 1px solid rgb(222, 226, 230); color: #313131;"></td>
                                            <td style="padding: 12px 11px; border-bottom: 1px solid #078A8E; padding: 19px 11px 18px; text-align: center; font-size: 16px; font-weight: normal; font-family: Circular Std; line-height: 22.77px; border-bottom: 1px solid rgb(222, 226, 230); color: #313131;"></td>
                                            <td style="padding: 12px 11px; border-bottom: 1px solid #078A8E; padding: 19px 11px 18px; text-align: center; font-size: 16px; font-weight: normal; font-family: Circular Std; line-height: 22.77px; border-bottom: 1px solid rgb(222, 226, 230); color: #313131;"></td>
                                            <td style="padding: 12px 11px; border-bottom: 1px solid #078A8E; padding: 19px 11px 18px; text-align: center; font-size: 16px; font-weight: normal; font-family: Circular Std; line-height: 22.77px; border-bottom: 1px solid rgb(222, 226, 230); color: #313131;">
                                                <table style="width: 100%;" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td><span style="color: #078A8E;">M</span></td>
                                                        <td><span style="color: #078A8E;">F</span></td>
                                                        <td><span style="color: #078A8E;">E</span></td>
                                                        <td><span style="color: #078A8E;">N</span></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td style="padding: 12px 11px; border-bottom: 1px solid #078A8E; padding: 19px 11px 18px; text-align: center; font-size: 16px; font-weight: normal; font-family: Circular Std; line-height: 22.77px; border-bottom: 1px solid rgb(222, 226, 230); color: #313131;"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table style="margin-bottom: 0; width: 100%; border-collapse: collapse;">
                                        <thead>
                                        </thead>
                                                 <tbody>
    @foreach($prescription as $prescriptionItem)
    <tr>
 <td style="padding: 19px 11px 18px; text-align: center; font-size: 18px; font-weight: 500; font-family: Circular Std; line-height: 22.77px; border-bottom: 1px solid rgb(222, 226, 230); color: #313131;">
    @if ($prescriptionItem->prescribedElements->isNotEmpty())
        @foreach ($prescriptionItem->prescribedElements as $element)
            @if($element->type  == "medicine" || $element->type  == "insulin")
                {{ $element->medicine->name ?? '' }}
            @endif
        @endforeach
    @endif
</td>   <td style="padding: 19px 11px 18px; text-align: center; font-size: 18px; font-weight: 500; font-family: Circular Std; line-height: 22.77px; border-bottom: 1px solid rgb(222, 226, 230); color: #313131;">
    @if ($prescriptionItem->prescribedElements->isNotEmpty())
        @foreach ($prescriptionItem->prescribedElements as $element)
        @if($element->type == "medicine" || $element->type  == "insulin")
            {{ $element->medicineGeneric->name ?? '' }}
            @endif
        @endforeach
    @endif
</td>          
 <td style="padding: 19px 11px 18px; text-align: center; font-size: 18px; font-weight: 500; font-family: Circular Std; line-height: 22.77px; border-bottom: 1px solid rgb(222, 226, 230); color: #313131;">
    @if ($prescriptionItem->prescribedElements->isNotEmpty())
        @foreach ($prescriptionItem->prescribedElements as $element)
        @if($element->type  == "medicine" || $element->type  == "insulin")
            {{ $element->type ?? '' }}
            @endif
        @endforeach
    @endif
</td>  
 <td style="padding: 19px 11px 18px; text-align: center; font-size: 18px; font-weight: 500; font-family: Circular Std; line-height: 22.77px; border-bottom: 1px solid rgb(222, 226, 230); color: #313131;">
    @if ($prescriptionItem->prescribedElements->isNotEmpty())
        @foreach ($prescriptionItem->prescribedElements as $element)
        @if($element->type  == "medicine" || $element->type  == "insulin")
            {{ $element->medicineRoute->name ?? '' }}
            @endif
        @endforeach
    @endif
</td>   
 <td style="padding: 19px 11px 18px; text-align: center; font-size: 18px; font-weight: 500; font-family: Circular Std; line-height: 22.77px; border-bottom: 1px solid rgb(222, 226, 230); color: #313131;">
    @if ($prescriptionItem->prescribedElements->isNotEmpty())
        @foreach ($prescriptionItem->prescribedElements as $element)
        @if($element->type  == "medicine" || $element->type == "insulin")
            {{ $element->item_strength_id ?? '' }}
            @endif
        @endforeach
    @endif
</td> 
   <td>
                <div class='gender-number' style="display: flex; justify-content: space-between; padding: 0 3px;">
                    <span>
                    @if ($prescriptionItem->prescribedElements->isNotEmpty())
                        @foreach ($prescriptionItem->prescribedElements as $element)
                        @if($element->type  == "medicine" || $element->type == "insulin")
                            {{ $element->number_of_days ?? '' }}
                            @endif
                        @endforeach
                    @endif
                </span>
                </div>
            </td>
        <td style="padding: 19px 11px 18px; text-align: center; font-size: 18px; font-weight: 500; font-family: Circular Std; line-height: 22.77px; border-bottom: 1px solid rgb(222, 226, 230); color: #313131;"><div class='gender-number' style="display: flex; justify-content: space-between; padding: 0 3px;">
                     @if ($prescriptionItem->prescribedElements->isNotEmpty())
                        @foreach ($prescriptionItem->prescribedElements as $element)
                        @if($element->type  == "medicine" || $element->type == "insulin")
                        <span>{{ $element->morning }}</span>
                        <span>{{ $element->noon }}</span>
                        <span>{{ $element->evening }}</span>
                        <span>{{ $element->night }}</span>
                            @endif
                        @endforeach
                    @endif

        </div></td>
   <td>
                <div class='gender-number' style="display: flex; justify-content: space-between; padding: 0 3px;">
                    <span>
                    @if ($prescriptionItem->prescribedElements->isNotEmpty())
                        @foreach ($prescriptionItem->prescribedElements as $element)
                        @if($element->type  == "medicine" || $element->type == "insulin")
                        {{ ($element->is_before_meal == 1) ? 'Before Meal' : '' }}
                            @endif
                        @endforeach
                    @endif
                    </span>
                </div>
            </td>    </tr>
    @endforeach
</tbody>
                                    </table>
                                    <table style="margin-bottom: 0; width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                <th style="padding-left: 32px; text-align: left; border: none; background-color: #F5F5F5; color: #313131; font-size: 18px; font-weight: bold; font-family: Circular Std; line-height: 25.3px; padding: 0.5rem .5rem;">Lab Test</th>
                                                <th style="padding-left: 32px; text-align: left; border: none; background-color: #F5F5F5; color: #313131; font-size: 18px; font-weight: bold; font-family: Circular Std; line-height: 25.3px; padding: 0.5rem .5rem;"></th>
                                                <th style="padding-left: 32px; text-align: left; border: none; background-color: #F5F5F5; color: #313131; font-size: 18px; font-weight: bold; font-family: Circular Std; line-height: 25.3px; padding: 0.5rem .5rem;"></th>
                                                <th style="padding-left: 32px; text-align: left; border: none; background-color: #F5F5F5; color: #313131; font-size: 18px; font-weight: bold; font-family: Circular Std; line-height: 25.3px; padding: 0.5rem .5rem;"></th>
                                                <th style="padding-left: 32px; text-align: left; border: none; background-color: #F5F5F5; color: #313131; font-size: 18px; font-weight: bold; font-family: Circular Std; line-height: 25.3px; padding: 0.5rem .5rem;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            @foreach($prescription as $prescriptionItem)
                                                @foreach ($prescriptionItem->prescribedElements as $elements)
                                                    @if ($elements->type == "lab")
                                                    <td style="padding-left: 32px; text-align: left; padding: 19px 11px; font-size: 16px; font-weight: normal; font-family: Circular Std; border-bottom: 1px solid rgb(222, 226, 230); line-height: 22.77px; color: #313131;">{{$elements->lab_name}}</td>
                                                    <td style="padding-left: 32px; text-align: left; padding: 19px 11px; font-size: 16px; font-weight: normal; font-family: Circular Std; border-bottom: 1px solid rgb(222, 226, 230); line-height: 22.77px; color: #313131;"></td>
                                                    <td style="padding-left: 32px; text-align: left; padding: 19px 11px; font-size: 16px; font-weight: normal; font-family: Circular Std; border-bottom: 1px solid rgb(222, 226, 230); line-height: 22.77px; color: #313131;"></td>
                                                    <td style="padding-left: 32px; text-align: left; padding: 19px 11px; font-size: 16px; font-weight: normal; font-family: Circular Std; border-bottom: 1px solid rgb(222, 226, 230); line-height: 22.77px; color: #313131;"></td>
                                                    <td style="padding-left: 32px; text-align: left; padding: 19px 11px; font-size: 16px; font-weight: normal; font-family: Circular Std; border-bottom: 1px solid rgb(222, 226, 230); line-height: 22.77px; color: #313131;"></td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div>
                                        <h5 style="background-color: #F5F5F5; font-size: 1.25rem; padding: 11px 0 11px .5rem;">Remarks</h5>
                                        <div style="padding: 26px 42px;">
                                        @foreach($prescription as $prescriptionItem)
                                            <textarea name="" placeholder='Glucerna half a glass twice a day' style="border: 0.5px solid #313131; padding: 14px 21px; border-radius: 12px; height: 78px; width: 96%; color: #313131; font-family: Circular Std; font-size: 16px; font-style: normal; font-weight: normal; line-height: normal;">{{$prescriptionItem->consultation_note}}</textarea>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>