<?php
namespace Magento\AcceptanceTest\_AppConfigDumpSuite\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-11158: Check that all input fields disabled after executing CLI app:config:dump")
 * @Description("Check that all input fields disabled after executing CLI app:config:dump. Command app:config:dump is not reversible and magento instance stays configuration read only after this test. You need to restore etc/env.php manually to make magento configuration writable again.<h3>Test files</h3>app/code/Magento/Dhl/Test/Mftf/Test/AdminCheckInputFieldsDisabledAfterAppConfigDumpTest.xml<br>app/code/Magento/Fedex/Test/Mftf/Test/AdminCheckInputFieldsDisabledAfterAppConfigDumpTest.xml<br>app/code/Magento/Shipping/Test/Mftf/Test/AdminCheckInputFieldsDisabledAfterAppConfigDumpTest.xml<br>app/code/Magento/Ups/Test/Mftf/Test/AdminCheckInputFieldsDisabledAfterAppConfigDumpTest.xml<br>app/code/Magento/Usps/Test/Mftf/Test/AdminCheckInputFieldsDisabledAfterAppConfigDumpTest.xml<br>")
 * @TestCaseId("MC-11158")
 * @group configuration
 */
class AdminCheckInputFieldsDisabledAfterAppConfigDumpTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Command app:config:dump is not reversible and magento instance stays configuration read only after this test. You need to restore etc/env.php manually to make magento configuration writable again.");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Dhl"})
	 * @Stories({"Disable configuration inputs"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckInputFieldsDisabledAfterAppConfigDumpTest(AcceptanceTester $I)
	{
		$I->comment("Assert configuration are disabled in DHL section");
		$I->comment("Assert configuration are disabled in DHL section");
		$I->comment("Entering Action Group [openShippingMethodConfigPage] AdminOpenShippingMethodsConfigPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/carriers/"); // stepKey: navigateToAdminShippingMethodsPageOpenShippingMethodConfigPage
		$I->waitForPageLoad(30); // stepKey: waitForAdminShippingMethodsPageToLoadOpenShippingMethodConfigPage
		$I->comment("Exiting Action Group [openShippingMethodConfigPage] AdminOpenShippingMethodsConfigPageActionGroup");
		$I->conditionalClick("#carriers_dhl-head", "#carriers_dhl_active_inherit", false); // stepKey: expandDHLTab
		$I->waitForElementVisible("#carriers_dhl_active_inherit", 30); // stepKey: waitDHLTabOpen
		$grabDHLActiveDisabled = $I->grabAttributeFrom("#carriers_dhl_active_inherit", "disabled"); // stepKey: grabDHLActiveDisabled
		$I->assertEquals("true", $grabDHLActiveDisabled); // stepKey: assertDHLActiveDisabled
		$grabDHLTitleDisabled = $I->grabAttributeFrom("#carriers_dhl_title_inherit", "disabled"); // stepKey: grabDHLTitleDisabled
		$I->assertEquals("true", $grabDHLTitleDisabled); // stepKey: assertDHLTitleDisabled
		$grabDHLAccessIdDisabled = $I->grabAttributeFrom("#carriers_dhl_id", "disabled"); // stepKey: grabDHLAccessIdDisabled
		$I->assertEquals("true", $grabDHLAccessIdDisabled); // stepKey: assertDHLAccessIdDisabled
		$grabDHLPasswordDisabled = $I->grabAttributeFrom("#carriers_dhl_password", "disabled"); // stepKey: grabDHLPasswordDisabled
		$I->assertEquals("true", $grabDHLPasswordDisabled); // stepKey: assertDHLPasswordDisabled
		$grabDHLAccountDisabled = $I->grabAttributeFrom("#carriers_dhl_account_inherit", "disabled"); // stepKey: grabDHLAccountDisabled
		$I->assertEquals("true", $grabDHLAccountDisabled); // stepKey: assertDHLAccountDisabled
		$grabDHLContentTypeDisabled = $I->grabAttributeFrom("#carriers_dhl_content_type_inherit", "disabled"); // stepKey: grabDHLContentTypeDisabled
		$I->assertEquals("true", $grabDHLContentTypeDisabled); // stepKey: assertDHLContentTypeDisabled
		$grabDHLHandlingTypeDisabled = $I->grabAttributeFrom("#carriers_dhl_handling_type_inherit", "disabled"); // stepKey: grabDHLHandlingTypeDisabled
		$I->assertEquals("true", $grabDHLHandlingTypeDisabled); // stepKey: assertDHLHandlingTypeDisabled
		$grabDHLHandlingDisabled = $I->grabAttributeFrom("#carriers_dhl_handling_action_inherit", "disabled"); // stepKey: grabDHLHandlingDisabled
		$I->assertEquals("true", $grabDHLHandlingDisabled); // stepKey: assertDHLHandlingDisabled
		$grabDHLDivideOrderWeightDisabled = $I->grabAttributeFrom("#carriers_dhl_divide_order_weight_inherit", "disabled"); // stepKey: grabDHLDivideOrderWeightDisabled
		$I->assertEquals("true", $grabDHLDivideOrderWeightDisabled); // stepKey: assertDHLDivideOrderWeightDisabled
		$grabDHLUnitOfMeasureDisabled = $I->grabAttributeFrom("#carriers_dhl_unit_of_measure_inherit", "disabled"); // stepKey: grabDHLUnitOfMeasureDisabled
		$I->assertEquals("true", $grabDHLUnitOfMeasureDisabled); // stepKey: assertDHLUnitOfMeasureDisabled
		$grabDHLSizeDisabled = $I->grabAttributeFrom("#carriers_dhl_size_inherit", "disabled"); // stepKey: grabDHLSizeDisabled
		$I->assertEquals("true", $grabDHLSizeDisabled); // stepKey: assertDHLSizeDisabled
		$grabDHLNonDocAllowedMethodDisabled = $I->grabAttributeFrom("#carriers_dhl_nondoc_methods_inherit", "disabled"); // stepKey: grabDHLNonDocAllowedMethodDisabled
		$I->assertEquals("true", $grabDHLNonDocAllowedMethodDisabled); // stepKey: assertDHLNonDocAllowedMethodDisabled
		$grabDHLSmartPostHubIdDisabled = $I->grabAttributeFrom("#carriers_dhl_doc_methods_inherit", "disabled"); // stepKey: grabDHLSmartPostHubIdDisabled
		$I->assertEquals("true", $grabDHLSmartPostHubIdDisabled); // stepKey: assertDHLSmartPostHubIdDisabled
		$grabDHLSpecificErrMsgDisabled = $I->grabAttributeFrom("#carriers_dhl_specificerrmsg_inherit", "disabled"); // stepKey: grabDHLSpecificErrMsgDisabled
		$I->assertEquals("true", $grabDHLSpecificErrMsgDisabled); // stepKey: assertDHLSpecificErrMsgDisabled
		$I->comment("Assert configuration are disabled in FedEx section");
		$I->conditionalClick("#carriers_fedex-head", "#carriers_fedex_active_inherit", false); // stepKey: expandFedExTab
		$I->waitForElementVisible("#carriers_fedex_active_inherit", 30); // stepKey: waitFedExTabOpen
		$grabFedExActiveDisabled = $I->grabAttributeFrom("#carriers_fedex_active_inherit", "disabled"); // stepKey: grabFedExActiveDisabled
		$I->assertEquals("true", $grabFedExActiveDisabled); // stepKey: assertFedExActiveDisabled
		$grabFedExTitleDisabled = $I->grabAttributeFrom("#carriers_fedex_title_inherit", "disabled"); // stepKey: grabFedExTitleDisabled
		$I->assertEquals("true", $grabFedExTitleDisabled); // stepKey: assertFedExTitleDisabled
		$grabFedExAccountIdDisabled = $I->grabAttributeFrom("#carriers_fedex_account", "disabled"); // stepKey: grabFedExAccountIdDisabled
		$I->assertEquals("true", $grabFedExAccountIdDisabled); // stepKey: assertFedExAccountIdDisabled
		$grabFedExMeterNumberDisabled = $I->grabAttributeFrom("#carriers_fedex_meter_number", "disabled"); // stepKey: grabFedExMeterNumberDisabled
		$I->assertEquals("true", $grabFedExMeterNumberDisabled); // stepKey: assertFedExMeterNumberDisabled
		$grabFedExKeyDisabled = $I->grabAttributeFrom("#carriers_fedex_key", "disabled"); // stepKey: grabFedExKeyDisabled
		$I->assertEquals("true", $grabFedExKeyDisabled); // stepKey: assertFedExKeyDisabled
		$grabFedExPasswordDisabled = $I->grabAttributeFrom("#carriers_fedex_password", "disabled"); // stepKey: grabFedExPasswordDisabled
		$I->assertEquals("true", $grabFedExPasswordDisabled); // stepKey: assertFedExPasswordDisabled
		$grabFedExSandboxDisabled = $I->grabAttributeFrom("#carriers_fedex_sandbox_mode_inherit", "disabled"); // stepKey: grabFedExSandboxDisabled
		$I->assertEquals("true", $grabFedExSandboxDisabled); // stepKey: assertFedExSandboxDisabled
		$grabFedExShipmentRequestTypeDisabled = $I->grabAttributeFrom("#carriers_fedex_shipment_requesttype_inherit", "disabled"); // stepKey: grabFedExShipmentRequestTypeDisabled
		$I->assertEquals("true", $grabFedExShipmentRequestTypeDisabled); // stepKey: assertFedExShipmentRequestTypeDisabled
		$grabFedExPackagingDisabled = $I->grabAttributeFrom("#carriers_fedex_packaging_inherit", "disabled"); // stepKey: grabFedExPackagingDisabled
		$I->assertEquals("true", $grabFedExPackagingDisabled); // stepKey: assertFedExPackagingDisabled
		$grabFedExDropoffDisabled = $I->grabAttributeFrom("#carriers_fedex_dropoff_inherit", "disabled"); // stepKey: grabFedExDropoffDisabled
		$I->assertEquals("true", $grabFedExDropoffDisabled); // stepKey: assertFedExDropoffDisabled
		$grabFedExUnitOfMeasureDisabled = $I->grabAttributeFrom("#carriers_fedex_unit_of_measure_inherit", "disabled"); // stepKey: grabFedExUnitOfMeasureDisabled
		$I->assertEquals("true", $grabFedExUnitOfMeasureDisabled); // stepKey: assertFedExUnitOfMeasureDisabled
		$grabFedExMaxPackageWeightDisabled = $I->grabAttributeFrom("#carriers_fedex_max_package_weight_inherit", "disabled"); // stepKey: grabFedExMaxPackageWeightDisabled
		$I->assertEquals("true", $grabFedExMaxPackageWeightDisabled); // stepKey: assertFedExMaxPackageWeightDisabled
		$grabFedExHandlingTypeDisabled = $I->grabAttributeFrom("#carriers_fedex_handling_type_inherit", "disabled"); // stepKey: grabFedExHandlingTypeDisabled
		$I->assertEquals("true", $grabFedExHandlingTypeDisabled); // stepKey: assertFedExHandlingTypeDisabled
		$grabFedExHandlingActionDisabled = $I->grabAttributeFrom("#carriers_fedex_handling_action_inherit", "disabled"); // stepKey: grabFedExHandlingActionDisabled
		$I->assertEquals("true", $grabFedExHandlingActionDisabled); // stepKey: assertFedExHandlingActionDisabled
		$grabFedExSpecificErrMsgDisabled = $I->grabAttributeFrom("#carriers_fedex_specificerrmsg_inherit", "disabled"); // stepKey: grabFedExSpecificErrMsgDisabled
		$I->assertEquals("true", $grabFedExSpecificErrMsgDisabled); // stepKey: assertFedExSpecificErrMsgDisabled
		$grabFedExAllowSpecificDisabled = $I->grabAttributeFrom("#carriers_fedex_sallowspecific_inherit", "disabled"); // stepKey: grabFedExAllowSpecificDisabled
		$I->assertEquals("true", $grabFedExAllowSpecificDisabled); // stepKey: assertFedExAllowSpecificDisabled
		$grabFedExSpecificCountryDisabled = $I->grabAttributeFrom("#carriers_fedex_specificcountry", "disabled"); // stepKey: grabFedExSpecificCountryDisabled
		$I->assertEquals("true", $grabFedExSpecificCountryDisabled); // stepKey: assertFedExSpecificCountryDisabled
		$I->comment("Assert configuration are disabled in Flat Rate section");
		$I->conditionalClick("#carriers_flatrate-head", "#carriers_flatrate_active", false); // stepKey: expandFlatRateTab
		$I->waitForElementVisible("#carriers_flatrate_active_inherit", 30); // stepKey: waitForFlatRateTabOpen
		$grabFlatRateActiveDisabled = $I->grabAttributeFrom("#carriers_flatrate_active_inherit", "disabled"); // stepKey: grabFlatRateActiveDisabled
		$I->assertEquals("true", $grabFlatRateActiveDisabled); // stepKey: assertFlatRateActiveDisabled
		$grabFlatRateTitleDisabled = $I->grabAttributeFrom("#carriers_flatrate_title_inherit", "disabled"); // stepKey: grabFlatRateTitleDisabled
		$I->assertEquals("true", $grabFlatRateTitleDisabled); // stepKey: assertFlatRateTitleDisabled
		$grabFlatRateNameDisabled = $I->grabAttributeFrom("#carriers_flatrate_name_inherit", "disabled"); // stepKey: grabFlatRateNameDisabled
		$I->assertEquals("true", $grabFlatRateNameDisabled); // stepKey: assertFlatRateNameDisabled
		$grabFlatRateSpecificErrMsgDisabled = $I->grabAttributeFrom("#carriers_flatrate_specificerrmsg_inherit", "disabled"); // stepKey: grabFlatRateSpecificErrMsgDisabled
		$I->assertEquals("true", $grabFlatRateSpecificErrMsgDisabled); // stepKey: assertFlatRateSpecificErrMsgDisabled
		$grabFlatRateAllowSpecificDisabled = $I->grabAttributeFrom("#carriers_flatrate_sallowspecific_inherit", "disabled"); // stepKey: grabFlatRateAllowSpecificDisabled
		$I->assertEquals("true", $grabFlatRateAllowSpecificDisabled); // stepKey: assertFlatRateAllowSpecificDisabled
		$grabFlatRateSpecificCountryDisabled = $I->grabAttributeFrom("#carriers_flatrate_specificcountry", "disabled"); // stepKey: grabFlatRateSpecificCountryDisabled
		$I->assertEquals("true", $grabFlatRateSpecificCountryDisabled); // stepKey: assertFlatRateSpecificCountryDisabled
		$I->comment("Assert configuration are disabled in Free Shipping section");
		$I->conditionalClick("#carriers_freeshipping-head", "#carriers_freeshipping_active_inherit", false); // stepKey: expandFreeShippingTab
		$I->waitForElementVisible("#carriers_freeshipping_active_inherit", 30); // stepKey: waitForFreeShippingTabOpen
		$grabFreeShippingActiveDisabled = $I->grabAttributeFrom("#carriers_freeshipping_active_inherit", "disabled"); // stepKey: grabFreeShippingActiveDisabled
		$I->assertEquals("true", $grabFreeShippingActiveDisabled); // stepKey: assertFreeShippingActiveDisabled
		$grabFreeShippingTitleDisabled = $I->grabAttributeFrom("#carriers_freeshipping_title_inherit", "disabled"); // stepKey: grabFreeShippingTitleDisabled
		$I->assertEquals("true", $grabFreeShippingTitleDisabled); // stepKey: assertFreeShippingTitleDisabled
		$grabFreeShippingNameDisabled = $I->grabAttributeFrom("#carriers_freeshipping_name_inherit", "disabled"); // stepKey: grabFreeShippingNameDisabled
		$I->assertEquals("true", $grabFreeShippingNameDisabled); // stepKey: assertFreeShippingNameDisabled
		$grabFreeShippingSpecificErrMsgDisabled = $I->grabAttributeFrom("#carriers_freeshipping_specificerrmsg_inherit", "disabled"); // stepKey: grabFreeShippingSpecificErrMsgDisabled
		$I->assertEquals("true", $grabFreeShippingSpecificErrMsgDisabled); // stepKey: assertFreeShippingSpecificErrMsgDisabled
		$grabFreeShippingAllowSpecificDisabled = $I->grabAttributeFrom("#carriers_freeshipping_sallowspecific_inherit", "disabled"); // stepKey: grabFreeShippingAllowSpecificDisabled
		$I->assertEquals("true", $grabFreeShippingAllowSpecificDisabled); // stepKey: assertFreeShippingAllowSpecificDisabled
		$grabFreeShippingSpecificCountryDisabled = $I->grabAttributeFrom("#carriers_freeshipping_specificcountry", "disabled"); // stepKey: grabFreeShippingSpecificCountryDisabled
		$I->assertEquals("true", $grabFreeShippingSpecificCountryDisabled); // stepKey: assertFreeShippingSpecificCountryDisabled
		$I->comment("Assert configuration are disabled in Table Rates section");
		$I->conditionalClick("#carriers_tablerate-head", "#carriers_tablerate_active", false); // stepKey: expandTableRateTab
		$I->waitForElementVisible("#carriers_tablerate_active_inherit", 30); // stepKey: waitForTableRateTabOpen
		$grabTableRateActiveDisabled = $I->grabAttributeFrom("#carriers_tablerate_active_inherit", "disabled"); // stepKey: grabTableRateActiveDisabled
		$I->assertEquals("true", $grabTableRateActiveDisabled); // stepKey: assertTableRateActiveDisabled
		$grabTableRateTitleDisabled = $I->grabAttributeFrom("#carriers_tablerate_title_inherit", "disabled"); // stepKey: grabTableRateTitleDisabled
		$I->assertEquals("true", $grabTableRateTitleDisabled); // stepKey: assertTableRateTitleDisabled
		$grabTableRateNameDisabled = $I->grabAttributeFrom("#carriers_tablerate_name_inherit", "disabled"); // stepKey: grabTableRateNameDisabled
		$I->assertEquals("true", $grabTableRateNameDisabled); // stepKey: assertTableRateNameDisabled
		$grabTableRateConditionNameDisabled = $I->grabAttributeFrom("#carriers_tablerate_condition_name_inherit", "disabled"); // stepKey: grabTableRateConditionNameDisabled
		$I->assertEquals("true", $grabTableRateConditionNameDisabled); // stepKey: assertTableRateConditionNameDisabled
		$grabTableRateIncludeVirtualPriceDisabled = $I->grabAttributeFrom("#carriers_tablerate_include_virtual_price_inherit", "disabled"); // stepKey: grabTableRateIncludeVirtualPriceDisabled
		$I->assertEquals("true", $grabTableRateIncludeVirtualPriceDisabled); // stepKey: assertTableRateIncludeVirtualPriceDisabled
		$grabTableRateHandlingTypeDisabled = $I->grabAttributeFrom("#carriers_tablerate_handling_type_inherit", "disabled"); // stepKey: grabTableRateHandlingTypeDisabled
		$I->assertEquals("true", $grabTableRateHandlingTypeDisabled); // stepKey: assertTableRateHandlingTypeDisabled
		$grabTableRateSpecificErrMsgDisabled = $I->grabAttributeFrom("#carriers_tablerate_specificerrmsg_inherit", "disabled"); // stepKey: grabTableRateSpecificErrMsgDisabled
		$I->assertEquals("true", $grabTableRateSpecificErrMsgDisabled); // stepKey: assertTableRateSpecificErrMsgDisabled
		$grabTableRateAllowSpecificDisabled = $I->grabAttributeFrom("#carriers_tablerate_sallowspecific_inherit", "disabled"); // stepKey: grabTableRateAllowSpecificDisabled
		$I->assertEquals("true", $grabTableRateAllowSpecificDisabled); // stepKey: assertTableRateAllowSpecificDisabled
		$grabTableRateSpecificCountryDisabled = $I->grabAttributeFrom("#carriers_tablerate_specificcountry", "disabled"); // stepKey: grabTableRateSpecificCountryDisabled
		$I->assertEquals("true", $grabTableRateSpecificCountryDisabled); // stepKey: assertTableRateSpecificCountryDisabled
		$I->comment("Assert configuration are disabled in UPS section");
		$I->conditionalClick("#carriers_ups-head", "#carriers_ups_active_inherit", false); // stepKey: expandUPSTab
		$I->waitForElementVisible("#carriers_ups_active_inherit", 30); // stepKey: waitUPSTabOpen
		$grabUPSActiveDisabled = $I->grabAttributeFrom("#carriers_ups_active_inherit", "disabled"); // stepKey: grabUPSActiveDisabled
		$I->assertEquals("true", $grabUPSActiveDisabled); // stepKey: assertUPSActiveDisabled
		$grabUPSTypeDisabled = $I->grabAttributeFrom("#carriers_ups_type_inherit", "disabled"); // stepKey: grabUPSTypeDisabled
		$I->assertEquals("true", $grabUPSTypeDisabled); // stepKey: assertUPSTypeDisabled
		$grabUPSAccountLiveDisabled = $I->grabAttributeFrom("#carriers_ups_is_account_live_inherit", "disabled"); // stepKey: grabUPSAccountLiveDisabled
		$I->assertEquals("true", $grabUPSAccountLiveDisabled); // stepKey: assertUPSAccountLiveDisabled
		$grabUPSGatewayXMLUrlDisabled = $I->grabAttributeFrom("#carriers_ups_gateway_xml_url_inherit", "disabled"); // stepKey: grabUPSGatewayXMLUrlDisabled
		$I->assertEquals("true", $grabUPSGatewayXMLUrlDisabled); // stepKey: assertUPSGatewayXMLUrlDisabled
		$grabUPSModeXMLDisabled = $I->grabAttributeFrom("#carriers_ups_mode_xml_inherit", "disabled"); // stepKey: grabUPSModeXMLDisabled
		$I->assertEquals("true", $grabUPSModeXMLDisabled); // stepKey: assertUPSModeXMLDisabled
		$grabUPSOriginShipmentDisabled = $I->grabAttributeFrom("#carriers_ups_origin_shipment_inherit", "disabled"); // stepKey: grabUPSOriginShipmentDisabled
		$I->assertEquals("true", $grabUPSOriginShipmentDisabled); // stepKey: assertUPSOriginShipmentDisabled
		$grabUPSTitleDisabled = $I->grabAttributeFrom("#carriers_ups_title_inherit", "disabled"); // stepKey: grabUPSTitleDisabled
		$I->assertEquals("true", $grabUPSTitleDisabled); // stepKey: assertUPSTitleDisabled
		$grabUPSNegotiatedActiveDisabled = $I->grabAttributeFrom("#carriers_ups_negotiated_active_inherit", "disabled"); // stepKey: grabUPSNegotiatedActiveDisabled
		$I->assertEquals("true", $grabUPSNegotiatedActiveDisabled); // stepKey: assertUPSNegotiatedActiveDisabled
		$grabUPSIncludeTaxesDisabled = $I->grabAttributeFrom("#carriers_ups_include_taxes_inherit", "disabled"); // stepKey: grabUPSIncludeTaxesDisabled
		$I->assertEquals("true", $grabUPSIncludeTaxesDisabled); // stepKey: assertUPSIncludeTaxesDisabled
		$grabUPSShipmentRequestTypeDisabled = $I->grabAttributeFrom("#carriers_ups_shipment_requesttype_inherit", "disabled"); // stepKey: grabUPSShipmentRequestTypeDisabled
		$I->assertEquals("true", $grabUPSShipmentRequestTypeDisabled); // stepKey: assertUPSShipmentRequestTypeDisabled
		$grabUPSContainerDisabled = $I->grabAttributeFrom("#carriers_ups_container_inherit", "disabled"); // stepKey: grabUPSContainerDisabled
		$I->assertEquals("true", $grabUPSContainerDisabled); // stepKey: assertUPSContainerDisabled
		$grabUPSDestTypeDisabled = $I->grabAttributeFrom("#carriers_ups_dest_type_inherit", "disabled"); // stepKey: grabUPSDestTypeDisabled
		$I->assertEquals("true", $grabUPSDestTypeDisabled); // stepKey: assertUPSDestTypeDisabled
		$grabUPSTrackingXmlUrlDisabled = $I->grabAttributeFrom("#carriers_ups_tracking_xml_url_inherit", "disabled"); // stepKey: grabUPSTrackingXmlUrlDisabled
		$I->assertEquals("true", $grabUPSTrackingXmlUrlDisabled); // stepKey: assertUPSTrackingXmlUrlDisabled
		$grabUPSUnitOfMeasureDisabled = $I->grabAttributeFrom("#carriers_ups_unit_of_measure_inherit", "disabled"); // stepKey: grabUPSUnitOfMeasureDisabled
		$I->assertEquals("true", $grabUPSUnitOfMeasureDisabled); // stepKey: assertUPSUnitOfMeasureDisabled
		$grabUPSMaxPackageWeightDisabled = $I->grabAttributeFrom("#carriers_ups_max_package_weight_inherit", "disabled"); // stepKey: grabUPSMaxPackageWeightDisabled
		$I->assertEquals("true", $grabUPSMaxPackageWeightDisabled); // stepKey: assertUPSMaxPackageWeightDisabled
		$grabUPSPickupDisabled = $I->grabAttributeFrom("#carriers_ups_pickup_inherit", "disabled"); // stepKey: grabUPSPickupDisabled
		$I->assertEquals("true", $grabUPSPickupDisabled); // stepKey: assertUPSPickupDisabled
		$grabUPSMinPackageWeightDisabled = $I->grabAttributeFrom("#carriers_ups_min_package_weight_inherit", "disabled"); // stepKey: grabUPSMinPackageWeightDisabled
		$I->assertEquals("true", $grabUPSMinPackageWeightDisabled); // stepKey: assertUPSMinPackageWeightDisabled
		$grabUPSHandlingTypeDisabled = $I->grabAttributeFrom("#carriers_ups_handling_type_inherit", "disabled"); // stepKey: grabUPSHandlingTypeDisabled
		$I->assertEquals("true", $grabUPSHandlingTypeDisabled); // stepKey: assertUPSHandlingTypeDisabled
		$grabUPSHandlingActionDisabled = $I->grabAttributeFrom("#carriers_ups_handling_action_inherit", "disabled"); // stepKey: grabUPSHandlingActionDisabled
		$I->assertEquals("true", $grabUPSHandlingActionDisabled); // stepKey: assertUPSHandlingActionDisabled
		$grabUPSAllowedMethodsDisabled = $I->grabAttributeFrom("#carriers_ups_allowed_methods_inherit", "disabled"); // stepKey: grabUPSAllowedMethodsDisabled
		$I->assertEquals("true", $grabUPSAllowedMethodsDisabled); // stepKey: assertUPSAllowedMethodsDisabled
		$grabUPSFreeMethodDisabled = $I->grabAttributeFrom("#carriers_ups_free_method_inherit", "disabled"); // stepKey: grabUPSFreeMethodDisabled
		$I->assertEquals("true", $grabUPSFreeMethodDisabled); // stepKey: assertUPSFreeMethodDisabled
		$grabUPSSpecificErrMsgDisabled = $I->grabAttributeFrom("#carriers_ups_specificerrmsg_inherit", "disabled"); // stepKey: grabUPSSpecificErrMsgDisabled
		$I->assertEquals("true", $grabUPSSpecificErrMsgDisabled); // stepKey: assertUPSSpecificErrMsgDisabled
		$grabUPSAllowSpecificDisabled = $I->grabAttributeFrom("#carriers_ups_sallowspecific_inherit", "disabled"); // stepKey: grabUPSAllowSpecificDisabled
		$I->assertEquals("true", $grabUPSAllowSpecificDisabled); // stepKey: assertUPSAllowSpecificDisabled
		$grabUPSSpecificCountryDisabled = $I->grabAttributeFrom("#carriers_ups_specificcountry", "disabled"); // stepKey: grabUPSSpecificCountryDisabled
		$I->assertEquals("true", $grabUPSSpecificCountryDisabled); // stepKey: assertUPSSpecificCountryDisabled
		$I->comment("Assert configuration are disabled in USPS section");
		$I->conditionalClick("#carriers_usps-head", "#carriers_usps_active_inherit", false); // stepKey: expandUSPSTab
		$I->waitForElementVisible("#carriers_usps_active_inherit", 30); // stepKey: waitUSPSTabOpen
		$grabUSPSActiveDisabled = $I->grabAttributeFrom("#carriers_usps_active_inherit", "disabled"); // stepKey: grabUSPSActiveDisabled
		$I->assertEquals("true", $grabUSPSActiveDisabled); // stepKey: assertUSPSActiveDisabled
		$grabUSPSGatewayXMLUrlDisabled = $I->grabAttributeFrom("#carriers_usps_gateway_url_inherit", "disabled"); // stepKey: grabUSPSGatewayXMLUrlDisabled
		$I->assertEquals("true", $grabUSPSGatewayXMLUrlDisabled); // stepKey: assertUSPSGatewayXMLUrlDisabled
		$grabUSPSGatewaySecureUrlDisabled = $I->grabAttributeFrom("#carriers_usps_gateway_secure_url_inherit", "disabled"); // stepKey: grabUSPSGatewaySecureUrlDisabled
		$I->assertEquals("true", $grabUSPSGatewaySecureUrlDisabled); // stepKey: assertUSPSGatewaySecureUrlDisabled
		$grabUSPSTitleDisabled = $I->grabAttributeFrom("#carriers_usps_title_inherit", "disabled"); // stepKey: grabUSPSTitleDisabled
		$I->assertEquals("true", $grabUSPSTitleDisabled); // stepKey: assertUSPSTitleDisabled
		$grabUSPSUserIdDisabled = $I->grabAttributeFrom("#carriers_usps_userid", "disabled"); // stepKey: grabUSPSUserIdDisabled
		$I->assertEquals("true", $grabUSPSUserIdDisabled); // stepKey: assertUSPSUserIdDisabled
		$grabUSPSPasswordDisabled = $I->grabAttributeFrom("#carriers_usps_password", "disabled"); // stepKey: grabUSPSPasswordDisabled
		$I->assertEquals("true", $grabUSPSPasswordDisabled); // stepKey: assertUSPSPasswordDisabled
		$grabUSPSShipmentRequestTypeDisabled = $I->grabAttributeFrom("#carriers_usps_shipment_requesttype_inherit", "disabled"); // stepKey: grabUSPSShipmentRequestTypeDisabled
		$I->assertEquals("true", $grabUSPSShipmentRequestTypeDisabled); // stepKey: assertUSPSShipmentRequestTypeDisabled
		$grabUSPSContainerDisabled = $I->grabAttributeFrom("#carriers_usps_container_inherit", "disabled"); // stepKey: grabUSPSContainerDisabled
		$I->assertEquals("true", $grabUSPSContainerDisabled); // stepKey: assertUSPSContainerDisabled
		$grabUSPSSizeDisabled = $I->grabAttributeFrom("#carriers_usps_size_inherit", "disabled"); // stepKey: grabUSPSSizeDisabled
		$I->assertEquals("true", $grabUSPSSizeDisabled); // stepKey: assertUSPSSizeDisabled
		$grabUSPSDestTypeDisabled = $I->grabAttributeFrom("#carriers_usps_machinable_inherit", "disabled"); // stepKey: grabUSPSDestTypeDisabled
		$I->assertEquals("true", $grabUSPSDestTypeDisabled); // stepKey: assertUSPSDestTypeDisabled
		$grabUSPSMachinableDisabled = $I->grabAttributeFrom("#carriers_ups_tracking_xml_url_inherit", "disabled"); // stepKey: grabUSPSMachinableDisabled
		$I->assertEquals("true", $grabUSPSMachinableDisabled); // stepKey: assertUSPSMachinableDisabled
		$grabUSPSMaxPackageWeightDisabled = $I->grabAttributeFrom("#carriers_usps_max_package_weight_inherit", "disabled"); // stepKey: grabUSPSMaxPackageWeightDisabled
		$I->assertEquals("true", $grabUSPSMaxPackageWeightDisabled); // stepKey: assertUSPSMaxPackageWeightDisabled
		$grabUSPSHandlingTypeDisabled = $I->grabAttributeFrom("#carriers_usps_handling_type_inherit", "disabled"); // stepKey: grabUSPSHandlingTypeDisabled
		$I->assertEquals("true", $grabUSPSHandlingTypeDisabled); // stepKey: assertUSPSHandlingTypeDisabled
		$grabUSPSHandlingActionDisabled = $I->grabAttributeFrom("#carriers_usps_handling_action_inherit", "disabled"); // stepKey: grabUSPSHandlingActionDisabled
		$I->assertEquals("true", $grabUSPSHandlingActionDisabled); // stepKey: assertUSPSHandlingActionDisabled
		$grabUSPSAllowedMethodsDisabled = $I->grabAttributeFrom("#carriers_usps_allowed_methods_inherit", "disabled"); // stepKey: grabUSPSAllowedMethodsDisabled
		$I->assertEquals("true", $grabUSPSAllowedMethodsDisabled); // stepKey: assertUSPSAllowedMethodsDisabled
		$grabUSPSFreeMethodDisabled = $I->grabAttributeFrom("#carriers_usps_free_method_inherit", "disabled"); // stepKey: grabUSPSFreeMethodDisabled
		$I->assertEquals("true", $grabUSPSFreeMethodDisabled); // stepKey: assertUSPSFreeMethodDisabled
		$grabUSPSSpecificErrMsgDisabled = $I->grabAttributeFrom("#carriers_usps_specificerrmsg_inherit", "disabled"); // stepKey: grabUSPSSpecificErrMsgDisabled
		$I->assertEquals("true", $grabUSPSSpecificErrMsgDisabled); // stepKey: assertUSPSSpecificErrMsgDisabled
		$grabUSPSAllowSpecificDisabled = $I->grabAttributeFrom("#carriers_usps_sallowspecific_inherit", "disabled"); // stepKey: grabUSPSAllowSpecificDisabled
		$I->assertEquals("true", $grabUSPSAllowSpecificDisabled); // stepKey: assertUSPSAllowSpecificDisabled
		$grabUSPSSpecificCountryDisabled = $I->grabAttributeFrom("#carriers_usps_specificcountry", "disabled"); // stepKey: grabUSPSSpecificCountryDisabled
		$I->assertEquals("true", $grabUSPSSpecificCountryDisabled); // stepKey: assertUSPSSpecificCountryDisabled
	}
}
