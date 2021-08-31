<?php
namespace Magento\AcceptanceTest\_default\Backend;

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
 * @Title("MC-13621: Update Customer Address, without zip/state required, default billing/shipping checked in Admin")
 * @Description("Update Customer Address, without zip/state required, default billing/shipping checked in Admin<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminUpdateCustomerTest/AdminUpdateCustomerAddressNoZipNoStateTest.xml<br>")
 * @TestCaseId("MC-13621")
 * @group Customer
 * @group mtf_migrated
 */
class AdminUpdateCustomerAddressNoZipNoStateTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
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
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("customer", "hook", "Simple_Customer_Without_Address", [], []); // stepKey: customer
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
	}

	/**
	 * @Features({"Customer"})
	 * @Stories({"Update Customer Information in Admin"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateCustomerAddressNoZipNoStateTest(AcceptanceTester $I)
	{
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('customer', 'id', 'test') . "/"); // stepKey: openCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: waitForCustomerEditPage
		$I->comment("Update Customer Account Information");
		$I->comment("Update Customer Addresses");
		$I->comment("Entering Action Group [editCustomerAddress] AdminEditCustomerAddressNoZipNoStateActionGroup");
		$I->click("//span[text()='Addresses']"); // stepKey: proceedToAddressesEditCustomerAddress
		$I->waitForPageLoad(30); // stepKey: proceedToAddressesEditCustomerAddressWaitForPageLoad
		$I->click("//span[text()='Add New Address']"); // stepKey: addNewAddressesEditCustomerAddress
		$I->waitForPageLoad(60); // stepKey: wait5678EditCustomerAddress
		$I->click("//input[@name='default_billing']/following-sibling::label"); // stepKey: setDefaultBillingEditCustomerAddress
		$I->click("//input[@name='default_shipping']/following-sibling::label"); // stepKey: setDefaultShippingEditCustomerAddress
		$I->fillField("input[name='prefix']", "Mr"); // stepKey: fillPrefixNameEditCustomerAddress
		$I->fillField("input[name='middlename']", "Mn"); // stepKey: fillMiddleNameEditCustomerAddress
		$I->fillField("input[name='suffix']", "Sr"); // stepKey: fillSuffixNameEditCustomerAddress
		$I->fillField("input[name='company']", "Magento"); // stepKey: fillCompanyEditCustomerAddress
		$I->fillField("input[name='street[0]']", "3962 Horner Street"); // stepKey: fillStreetAddressEditCustomerAddress
		$I->fillField("//*[@class='modal-component']//input[@name='city']", "London"); // stepKey: fillCityEditCustomerAddress
		$I->selectOption("//*[@class='modal-component']//select[@name='country_id']", "United Kingdom"); // stepKey: selectCountryEditCustomerAddress
		$I->fillField("//*[@class='modal-component']//input[@name='telephone']", "334-200-4061"); // stepKey: fillPhoneEditCustomerAddress
		$I->fillField("input[name='vat_id']", "U1234567891"); // stepKey: fillVATEditCustomerAddress
		$I->click("//button[@title='Save']"); // stepKey: saveAddressEditCustomerAddress
		$I->waitForPageLoad(30); // stepKey: waitForAddressSavedEditCustomerAddress
		$I->comment("Exiting Action Group [editCustomerAddress] AdminEditCustomerAddressNoZipNoStateActionGroup");
		$I->comment("Entering Action Group [saveAndCheckSuccessMessage] AdminSaveCustomerAndAssertSuccessMessage");
		$I->click("#save"); // stepKey: saveCustomerSaveAndCheckSuccessMessage
		$I->waitForPageLoad(30); // stepKey: saveCustomerSaveAndCheckSuccessMessageWaitForPageLoad
		$I->see("You saved the customer", ".message-success"); // stepKey: seeMessageSaveAndCheckSuccessMessage
		$I->comment("Exiting Action Group [saveAndCheckSuccessMessage] AdminSaveCustomerAndAssertSuccessMessage");
		$I->comment("Assert Customer in Customer Form");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('customer', 'id', 'test') . "/"); // stepKey: openCustomerEditPageAfterSave
		$I->waitForPageLoad(30); // stepKey: waitForCustomerEditPageAfterSave
		$I->comment("Assert Customer Account Information");
		$I->comment("Assert Customer Default Billing Address");
		$I->comment("Entering Action Group [checkDefaultBilling] AdminAssertCustomerDefaultBillingAddress");
		$I->click("//span[text()='Addresses']"); // stepKey: proceedToAddressesCheckDefaultBilling
		$I->waitForPageLoad(30); // stepKey: proceedToAddressesCheckDefaultBillingWaitForPageLoad
		$I->see($I->retrieveEntityField('customer', 'firstname', 'test'), "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: firstNameCheckDefaultBilling
		$I->see($I->retrieveEntityField('customer', 'lastname', 'test'), "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: lastNameCheckDefaultBilling
		$I->see("3962 Horner Street", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: street1CheckDefaultBilling
		$I->see("", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: stateCheckDefaultBilling
		$I->see("", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: postcodeCheckDefaultBilling
		$I->see("United Kingdom", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: countryCheckDefaultBilling
		$I->see("334-200-4061", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: telephoneCheckDefaultBilling
		$I->comment("Exiting Action Group [checkDefaultBilling] AdminAssertCustomerDefaultBillingAddress");
		$I->comment("Assert Customer Default Shipping Address");
		$I->comment("Entering Action Group [checkDefaultShipping] AdminAssertCustomerDefaultShippingAddress");
		$I->click("//span[text()='Addresses']"); // stepKey: proceedToAddressesCheckDefaultShipping
		$I->waitForPageLoad(30); // stepKey: proceedToAddressesCheckDefaultShippingWaitForPageLoad
		$I->see($I->retrieveEntityField('customer', 'firstname', 'test'), "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: firstNameCheckDefaultShipping
		$I->see($I->retrieveEntityField('customer', 'lastname', 'test'), "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: lastNameCheckDefaultShipping
		$I->see("3962 Horner Street", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: street1CheckDefaultShipping
		$I->see("", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: stateCheckDefaultShipping
		$I->see("", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: postcodeCheckDefaultShipping
		$I->see("United Kingdom", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: countryCheckDefaultShipping
		$I->see("334-200-4061", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: telephoneCheckDefaultShipping
		$I->comment("Exiting Action Group [checkDefaultShipping] AdminAssertCustomerDefaultShippingAddress");
		$I->comment("Entering Action Group [login] StorefrontAssertSuccessLoginToStorefront");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLogin
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailLogin
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillPasswordLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginWaitForPageLoad
		$I->see($I->retrieveEntityField('customer', 'firstname', 'test'), ".panel.header .greet.welcome"); // stepKey: assertWelcomeLogin
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLogin
		$I->comment("Exiting Action Group [login] StorefrontAssertSuccessLoginToStorefront");
		$I->comment("Remove steps that are not used for this test");
		$I->comment("Update Customer Addresses With No Zip and No State");
		$I->comment("Assert Customer Default Billing Address");
		$I->comment("Assert Customer Default Shipping Address");
		$I->comment("Assert Customer Login Storefront");
	}
}
