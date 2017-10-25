<?php

namespace PengYue\UserValidation\Bundle\ApiBundle\Controller\v1;

use PengYue\UserValidation\Bundle\ApiBundle\Service\PhoneNumber;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class PhoneNumberController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  resource=false,
     *  description="The endpoint to validate whether a phone number is valid",
     *  headers={
     *         {
     *             "name"="Access-Token",
     *             "description"="Domain ID or token"
     *         }
     *     },
     *     statusCodes={
     *          200="Returned when validation is successful",
     *          403="Returned when request is not authorised",
     *          500={
     *           "Returned when the number validation fails",
     *           "Returned when input param lead to the validation failure"
     *         }
     *     },
     *     parameters={
     *         {"name"="phone_number", "dataType"="string", "required"=true, "description"="the phone number to be validated"},
     *         {"name"="country_code", "dataType"="string", "required"=false, "description"="the country code which the phone number belongs to, if not provided, it is default to GB"}
     *     }
     *  )
     *
     * @return JsonResponse
     */
    public function validationPhoneNumberAction(Request $request)
    {
        $phoneNumber = $request->get('phone_number');
        $countryCode  = $request->get('country_code') ?: PhoneNumber::DEFAULT_COUNTRY_CODE;

        $phoneNumberModel = new PhoneNumber();
        $validated = $phoneNumberModel->isValid($phoneNumber, $countryCode);

        $response = new JsonResponse([
            'valid' => $validated,
        ]);

        return $response;
    }
}