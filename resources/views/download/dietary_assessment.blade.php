<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body style="margin: 0; padding: 0;">
    <div>
        <table cellpadding="0" cellspacing="0" style="max-width: 1277px;  padding: 64px 25px 35px 15px; margin: auto;">
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" style="width: 100%;">
                        <tr>
                            <td>
                                <div style="padding: 0 39px 35px;">
                                    <div
                                        style="display: flex; align-items: center;  justify-content: space-between;  margin-bottom: 4px;">
                                        <h3
                                            style="font-size: 28px;  font-weight: bold;  color: #19B3B5;  font-family: Nunito; line-height: 38.19px; margin: 0;">
                                            Dietary Assessment</h3>
                                    </div>
                                    <div
                                        style="border: 0.3px solid #313131;  border-radius: 14px;  position: relative;  padding: 23px 0 0;">
                                        <div style="padding: 0 18px 37px;">
                                            <h4
                                                style="font-size: 22px; font-weight: bold; margin: 0; margin-bottom: 28px; font-family: Nunito; line-height: 30.01px; color: #313131; padding: 0;">
                                                {{$patientInfo->name ?? ''}} - {{$patientInfo->mr_no ?? ''}}</h4>
                                   <img src="{{ public_path('assets/img/pdf-images/logo.png') }}" style="width: 190px; height: 40px; position: absolute; top: 23px; right: 31px;" />                                       

                                            <table style="border-collapse: collapse; width: 100%;">
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <h6
                                                                style="margin: 0; font-size: 16px; font-weight: normal; color: #313131; font-family: Nunito; margin-bottom: 8px; line-height: 22.77px;">
                                                                Age</h6>
                                                            <p
                                                                style="margin: 0; font-size: 18px; font-weight: bold; line-height: 22.77px; font-family: Nunito; color: #313131;">
                                                                {{$patientInfo->age ?? ''}}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h6
                                                                style="margin: 0; font-size: 16px; font-weight: normal; color: #313131; font-family: Nunito; margin-bottom: 8px; line-height: 22.77px;">
                                                                Gender</h6>
                                                            <p
                                                                style="margin: 0; font-size: 18px; font-weight: bold; line-height: 22.77px; font-family: Nunito; color: #313131;">
                                                                {{$patientInfo->gender ?? ''}}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h6
                                                                style="margin: 0; font-size: 16px; font-weight: normal; color: #313131; font-family: Nunito; margin-bottom: 8px; line-height: 22.77px;">
                                                                Date Of Birth</h6>
                                                            <p
                                                                style="margin: 0; font-size: 18px; font-weight: bold; line-height: 22.77px; font-family: Nunito; color: #313131;">
                                                                {{$patientInfo->date_of_birth ?? ''}}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h6
                                                                style="margin: 0; font-size: 16px; font-weight: normal; color: #313131; font-family: Nunito; margin-bottom: 8px; line-height: 22.77px;">
                                                                CNIC</h6>
                                                            <p
                                                                style="margin: 0; font-size: 18px; font-weight: bold; line-height: 22.77px; font-family: Nunito; color: #313131;">
                                                                {{$patientInfo->cnic ?? ''}}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h6
                                                                style="margin: 0; font-size: 16px; font-weight: normal; color: #313131; font-family: Nunito; margin-bottom: 8px; line-height: 22.77px;">
                                                                Address</h6>
                                                            <p
                                                                style="margin: 0; font-size: 18px; font-weight: bold; line-height: 22.77px; font-family: Nunito; color: #313131;">
                                                                {{$patientInfo->address ?? ''}}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h6
                                                                style="margin: 0; font-size: 16px; font-weight: normal; color: #313131; font-family: Nunito; margin-bottom: 8px; line-height: 22.77px;">
                                                                Ethnicity</h6>
                                                            <p
                                                                style="margin: 0; font-size: 18px; font-weight: bold; line-height: 22.77px; font-family: Nunito; color: #313131;">
                                                                {{$patientInfo->ethnicity($patientInfo->ethnicity) ?? ''}}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h6
                                                                style="margin: 0; font-size: 16px; font-weight: normal; color: #313131; font-family: Nunito; margin-bottom: 8px; line-height: 22.77px;">
                                                                Follow Up</h6>
                                                            <p
                                                                style="margin: 0; font-size: 18px; font-weight: bold; line-height: 22.77px; font-family: Nunito; color: #313131;">
                                                                {{ $dietaryAssessment->appoitment->follow_up_date }}</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <table style="margin-bottom: 0; border-collapse: collapse; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th
                                                        style="background: rgba(217, 217, 217, 0.6); text-align: center; padding: 10px 0.5rem 11px; color: #313131; font-weight: bold; font-size: 16.6px; font-family: Nunito">
                                                        Height (cm)</th>
                                                    <th
                                                        style="background: rgba(217, 217, 217, 0.6); text-align: center; padding: 10px 0.5rem 11px; color: #313131; font-weight: bold; font-size: 16.6px; font-family: Nunito">
                                                        Weight (kg)</th>
                                                    <th
                                                        style="background: rgba(217, 217, 217, 0.6); text-align: center; padding: 10px 0.5rem 11px; color: #313131; font-weight: bold; font-size: 16.6px; font-family: Nunito">
                                                        BMI</th>
                                                    <th
                                                        style="background: rgba(217, 217, 217, 0.6); text-align: center; padding: 10px 0.5rem 11px; color: #313131; font-weight: bold; font-size: 16.6px; font-family: Nunito">
                                                        IBW</th>
                                                    <th
                                                        style="background: rgba(217, 217, 217, 0.6); text-align: center; padding: 10px 0.5rem 11px; color: #313131; font-weight: bold; font-size: 16.6px; font-family: Nunito">
                                                        BEE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td
                                                        style="font-size: 18px; font-family: Nunito; font-weight: normal; text-align: center; padding: 13px 0.5rem; border: 0.1px solid #000000; color: #535151; width: 298px; border-right: none;border-left: none;">
                                                        {{$dietaryAssessment->height ?? ''}}</td>
                                                    <td
                                                        style="font-size: 18px; font-family: Nunito; font-weight: normal; text-align: center; padding: 13px 0.5rem; border: 0.1px solid #000000; color: #535151; width: 298px;">
                                                        {{$dietaryAssessment->weight ?? ''}}</td>
                                                    <td
                                                        style="font-size: 18px; font-family: Nunito; font-weight: normal; text-align: center; padding: 13px 0.5rem; border: 0.1px solid #000000; color: #535151; width: 298px;">
                                                        {{$dietaryAssessment->bmi ?? ''}}</td>
                                                    <td
                                                        style="font-size: 18px; font-family: Nunito; font-weight: normal; text-align: center; padding: 13px 0.5rem; border: 0.1px solid #000000; color: #535151; width: 298px;">
                                                        {{$dietaryAssessment->ibw ?? ''}}</td>
                                                    <td
                                                        style="font-size: 18px; font-family: Nunito; font-weight: normal; text-align: center; padding: 13px 0.5rem; border: 0.1px solid #000000; color: #535151; width: 298px; border-right: none;">
                                                        {{$dietaryAssessment->bee ?? ''}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table style="margin-bottom: 0; border-collapse: collapse; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th colSpan="6"
                                                        style="background: rgba(217, 217, 217, 0.6); padding: 10px 0.5rem 11px; color: #313131; font-weight: bold; font-size: 18.26px; font-family: Nunito; text-align: center;">
                                                        Food Groups</th>
                                                    <th colSpan="7"
                                                        style="background: rgba(217, 217, 217, 0.6); padding: 10px 0.5rem 11px; color: #313131; font-weight: bold; font-size: 18.26px; font-family: Nunito;">
                                                        Miscellaneous</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th
                                                        style="border-left: none; text-align: left; border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; padding: 8px 0.5rem; color: #535151; border-left: none;">
                                                        Meal Timing</th>
                                                    <th
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; padding: 8px 0.5rem; text-align: center; color: #535151;">
                                                        Cereal</th>
                                                    <th
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; padding: 8px 0.5rem; text-align: center; color: #535151;">
                                                        Vegetable</th>
                                                    <th
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; padding: 8px 0.5rem; text-align: center; color: #535151;">
                                                        Meat</th>
                                                    <th
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; padding: 8px 0.5rem; text-align: center; color: #535151;">
                                                        Milk</th>
                                                    <th
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; padding: 8px 0.5rem; text-align: center; color: #535151;">
                                                        Fruits</th>
                                                    <th
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; padding: 8px 0.5rem; text-align: center; color: #535151;">
                                                        Cereal</th>
                                                    <th
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; padding: 8px 0.5rem; text-align: center; color: #535151;">
                                                        Fats</th>
                                                    <th
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; padding: 8px 0.5rem; text-align: center; color: #535151;">
                                                        Calories</th>
                                                    <th
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; padding: 8px 0.5rem; text-align: center; color: #535151;">
                                                        Carbo</th>
                                                    <th
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; padding: 8px 0.5rem; text-align: center; color: #535151;">
                                                        Fats</th>
                                                    <th
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; padding: 8px 0.5rem; text-align: center; color: #535151;">
                                                        Protein</th>
                                                    <th
                                                        style="border-right: none; border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; padding: 8px 0.5rem; text-align: center; color: #535151; border-right: none;">
                                                        Calories</th>
                                                </tr>
                                                @foreach($dietaryAssessment->mealEntries as $entry)
                
                                                <tr>
                                                    <th
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; padding: 8px 0.5rem; text-align: center; color: #535151; text-align: left; border-left: none;">
                                                        {{ $entry->mealTime->name ??'' }}</th>
                                                    <td
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; text-align: center; padding: 8px 0.5rem; color: #535151;">
                                                        {{ $entry->cereal }}</td>
                                                    <td
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; text-align: center; padding: 8px 0.5rem; color: #535151;">
                                                        {{ $entry->vegetable }}</td>
                                                    <td
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; text-align: center; padding: 8px 0.5rem; color: #535151;">
                                                        {{ $entry->meat }}</td>
                                                    <td
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; text-align: center; padding: 8px 0.5rem; color: #535151;">
                                                        {{ $entry->milk }}</td>
                                                    <td
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; text-align: center; padding: 8px 0.5rem; color: #535151;">
                                                        {{ $entry->fruits }}</td>
                                                    <td
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; text-align: center; padding: 8px 0.5rem; color: #535151;">
                                                        {{ $entry->miscCereal }}</td>
                                                    <td
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; text-align: center; padding: 8px 0.5rem; color: #535151;">
                                                        {{ $entry->miscFats }}</td>
                                                    <td
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; text-align: center; padding: 8px 0.5rem; color: #535151;">
                                                        {{ $entry->calories }}</td>
                                                    <td
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; text-align: center; padding: 8px 0.5rem; color: #535151;">
                                                        {{ $entry->carbo }}</td>
                                                    <td
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; text-align: center; padding: 8px 0.5rem; color: #535151;">
                                                        {{ $entry->fats }}</td>
                                                    <td
                                                        style="border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; text-align: center; padding: 8px 0.5rem; color: #535151;">
                                                        {{ $entry->protein }}</td>
                                                    <td
                                                        style="border-right: none; border: 0.49px solid #959494; font-size: 14.94px; font-family: Nunito; font-weight: bold; text-align: center; padding: 8px 0.5rem; color: #535151; border-right: none;">
                                                        {{ $entry->miscCalories }}</td>
                                                </tr>
                
                                                @endforeach
                
                                            </tbody>
                                        </table>
                                        <table style="width: 100%; border-collapse: collapse;">
                                            <thead>
                                                <tr>
                                                    <th
                                                        style="background: rgba(217, 217, 217, 0.6); text-align: center; padding: 10px 0.5rem 11px; color: #313131; font-weight: bold; font-size: 16.6px; font-family: Nunito;">
                                                        {{ $dietaryAssessment->visit }}</th>
                                                    <th
                                                        style="background: rgba(217, 217, 217, 0.6); text-align: center; padding: 10px 0.5rem 11px; color: #313131; font-weight: bold; font-size: 16.6px; font-family: Nunito;">
                                                        {{ $dietaryAssessment->activityFactor }}</th>
                                                    <th
                                                        style="background: rgba(217, 217, 217, 0.6); text-align: center; padding: 10px 0.5rem 11px; color: #313131; font-weight: bold; font-size: 16.6px; font-family: Nunito;">
                                                        {{ $dietaryAssessment->injuryFactor }}</th>
                                                    <th
                                                        style="background: rgba(217, 217, 217, 0.6); text-align: center; padding: 10px 0.5rem 11px; color: #313131; font-weight: bold; font-size: 16.6px; font-family: Nunito;">
                                                        {{ $dietaryAssessment->fatIntake }}</th>
                                                    <th
                                                        style="background: rgba(217, 217, 217, 0.6); text-align: center; padding: 10px 0.5rem 11px; color: #313131; font-weight: bold; font-size: 16.6px; font-family: Nunito;">
                                                        {{ $dietaryAssessment->calIntake }}</th>
                                                    <th
                                                        style="background: rgba(217, 217, 217, 0.6); text-align: center; padding: 10px 0.5rem 11px; color: #313131; font-weight: bold; font-size: 16.6px; font-family: Nunito;">
                                                        {{ $dietaryAssessment->calReq }}</th>
                                                    <th
                                                        style="background: rgba(217, 217, 217, 0.6); text-align: center; padding: 10px 0.5rem 11px; color: #313131; font-weight: bold; font-size: 16.6px; font-family: Nunito;">
                                                        {{ $dietaryAssessment->calAdvised }}</th>
                                                    <th
                                                        style="background: rgba(217, 217, 217, 0.6); text-align: center; padding: 10px 0.5rem 11px; color: #313131; font-weight: bold; font-size: 16.6px; font-family: Nunito;">
                                                        {{ $dietaryAssessment->compliance }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td
                                                        style="border-left: none; font-size: 18px; font-family: Nunito; font-weight: normal; padding: 13px 0.5rem; text-align: center; border: 0.1px solid #000000; color: #535151; border-left: none;">
                                                        1</td>
                                                    <td
                                                        style="font-size: 18px; font-family: Nunito; font-weight: normal; padding: 13px 0.5rem; text-align: center; border: 0.1px solid #000000; color: #535151;">
                                                        {{ $dietaryAssessment->activity_factor }}</td>
                                                    <td
                                                        style="font-size: 18px; font-family: Nunito; font-weight: normal; padding: 13px 0.5rem; text-align: center; border: 0.1px solid #000000; color: #535151;">
                                                        {{ $dietaryAssessment->injury_factor }}</td>
                                                    <td
                                                        style="font-size: 18px; font-family: Nunito; font-weight: normal; padding: 13px 0.5rem; text-align: center; border: 0.1px solid #000000; color: #535151;">
                                                        {{ $dietaryAssessment->fats_intake }}</td>
                                                    <td
                                                        style="font-size: 18px; font-family: Nunito; font-weight: normal; padding: 13px 0.5rem; text-align: center; border: 0.1px solid #000000; color: #535151;">
                                                        {{ $dietaryAssessment->calories_intake }}</td>
                                                    <td
                                                        style="font-size: 18px; font-family: Nunito; font-weight: normal; padding: 13px 0.5rem; text-align: center; border: 0.1px solid #000000; color: #535151;">
                                                        {{ $dietaryAssessment->calories_required }}</td>
                                                    <td
                                                        style="font-size: 18px; font-family: Nunito; font-weight: normal; padding: 13px 0.5rem; text-align: center; border: 0.1px solid #000000; color: #535151;">
                                                        {{ $dietaryAssessment->calories_advised }}</td>
                                                    <td
                                                        style="border-right: none; font-size: 18px; font-family: Nunito; font-weight: normal; padding: 13px 0.5rem; text-align: center; border: 0.1px solid #000000; color: #535151; border-right: none;">
                                                        {{ $dietaryAssessment->compliance }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table style="width: 100%; border-collapse: collapse;">
                                            <thead>
                                                <tr>
                                                    <th colSpan="6"
                                                        style="background: rgba(217, 217, 217, 0.6); padding: 10px 0.5rem 11px; color: #313131; font-weight: bold; font-size: 16.6px; font-family: Nunito;">
                                                        Diet Advised</th>
                                                    <th colSpan="6"
                                                        style="background: rgba(217, 217, 217, 0.6); padding: 10px 0.5rem 11px; color: #313131; font-weight: bold; font-size: 16.6px; font-family: Nunito;">
                                                        Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th
                                                        style="font-size: 18px; width: 80px; font-family: Nunito; font-weight: normal; padding: 13px 0.5rem; border: 0.12px solid #000000; color: #535151; border-left: none; border-bottom: none;">
                                                        Protein:</th>
                                                    <td
                                                        style="font-size: 18px; width: 80px; font-family: Nunito; font-weight: normal; padding: 13px 0.5rem; border: 0.12px solid #000000; color: #535151; border-bottom: none;">
                                                    </td>
                                                    <th
                                                        style="border-left: none; font-size: 18px; width: 80px; font-family: Nunito; font-weight: normal; padding: 13px 0.5rem; border: 0.12px solid #000000; color: #535151; border-bottom: none;">
                                                        Calories:</th>
                                                    <td
                                                        style="font-size: 18px; width: 80px; font-family: Nunito; font-weight: normal; padding: 13px 0.5rem; border: 0.12px solid #000000; color: #535151; border-bottom: none;">
                                                    </td>
                                                    <th
                                                        style="border-left: none; font-size: 18px; width: 80px; font-family: Nunito; font-weight: normal; padding: 13px 0.5rem; border: 0.12px solid #000000; color: #535151; border-bottom: none;">
                                                        Sodium:</th>
                                                    <td
                                                        style="font-size: 18px; width: 80px; font-family: Nunito; font-weight: normal; padding: 13px 0.5rem; border: 0.12px solid #000000; color: #535151; border-bottom: none;">
                                                    </td>
                                                    <td colSpan="6"
                                                        style="font-size: 18px; width: 80px; font-family: Nunito; font-weight: normal; padding: 13px 0.5rem; border: 0.12px solid #000000; color: #535151; border-right: none; border-bottom: none;">
                                                        {{$dietaryAssessment->remarks}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </div>
    </div>
</body>

</html>