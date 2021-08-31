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
 * @Title("[NO TESTCASEID]: Admin user login as customer and edit customer's address")
 * @Description("Verify Admin can access customer's personal cabinet and change his default shipping and billing addresses using Login as Customer functionality<h3>Test files</h3>app/code/Magento/LoginAsCustomer/Test/Mftf/Test/AdminLoginAsCustomerEditCustomersAddressTest.xml<br>")
 * @group login_as_customer
 */
class AdminLoginAsCustomerEditCustomersAddressTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$enableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 1", 60); // stepKey: enableLoginAsCustomer
		$I->comment($enableLoginAsCustomer);
		$enableLoginAsCustomerAutoDetection = $I->magentoCLI("config:set login_as_customer/general/store_view_manual_choice_enabled 0", 60); // stepKey: enableLoginAsCustomerAutoDetection
		$I->comment($enableLoginAsCustomerAutoDetection);
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_Assistance_Allowed", [], []); // stepKey: createCustomer
		$I->comment("Entering Action Group [loginAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAdmin
		$I->comment("Exiting Action Group [loginAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logoutAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAdmin
		$I->comment("Exiting Action Group [logoutAdmin] AdminLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$disableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 0", 60); // stepKey: disableLoginAsCustomer
		$I->comment($disableLoginAsCustomer);
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
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
	 * @Features({"LoginAsCustomer"})
	 * @Stories({"Edit Customer addresses"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminLoginAsCustomerEditCustomersAddressTest(AcceptanceTester $I)
	{
		$I->comment("Login as Customer Login from Customer page");
		$I->comment("Entering Action Group [loginAsCustomerFromCustomerPage] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createCustomer', 'id', 'test')); // stepKey: gotoCustomerPageLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForCustomerPageLoadLoginAsCustomerFromCustomerPage
		$I->click("#login_as_customer"); // stepKey: clickLoginAsCustomerLinkLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: clickLoginAsCustomerLinkLoginAsCustomerFromCustomerPageWaitForPageLoad
		$I->see("You are about to Login as Customer", "aside.confirm .modal-title"); // stepKey: seeModalLoginAsCustomerFromCustomerPage
		$I->see("Actions taken while in \"Login as Customer\" will affect actual customer data.", "aside.confirm .modal-content"); // stepKey: seeModalMessageLoginAsCustomerFromCustomerPage
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickLoginLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(60); // stepKey: clickLoginLoginAsCustomerFromCustomerPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappearLoginAsCustomerFromCustomerPage
		$I->switchToNextTab(); // stepKey: switchToNewTabLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadLoginAsCustomerFromCustomerPage
		$I->comment("Exiting Action Group [loginAsCustomerFromCustomerPage] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->comment("Add new default address");
		$I->comment("Entering Action Group [addNewDefaultAddress] StorefrontAddCustomerDefaultAddressActionGroup");
		$I->amOnPage("customer/address/new/"); // stepKey: OpenCustomerAddNewAddressAddNewDefaultAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'firstname')]", "John"); // stepKey: fillFirstNameAddNewDefaultAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'lastname')]", "Doe"); // stepKey: fillLastNameAddNewDefaultAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'company')]", "Magento"); // stepKey: fillCompanyNameAddNewDefaultAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'telephone')]", "512-345-6789"); // stepKey: fillPhoneNumberAddNewDefaultAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'street')]", "7700 West Parmer Lane"); // stepKey: fillStreetAddressAddNewDefaultAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'city')]", "Los Angeles"); // stepKey: fillCityAddNewDefaultAddress
		$I->selectOption("//form[@class='form-address-edit']//select[contains(@name, 'region_id')]", "California"); // stepKey: selectStateAddNewDefaultAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'postcode')]", "90001"); // stepKey: fillZipAddNewDefaultAddress
		$I->selectOption("//form[@class='form-address-edit']//select[contains(@name, 'country_id')]", "United States"); // stepKey: selectCountryAddNewDefaultAddress
		$I->click("//form[@class='form-address-edit']//input[@name='default_billing']"); // stepKey: checkUseAsDefaultBillingAddressCheckBoxAddNewDefaultAddress
		$I->scrollTo("//form[@class='form-address-edit']//input[@name='default_shipping']"); // stepKey: scrollToUseAsDefaultShippingAddressCheckboxAddNewDefaultAddress
		$I->click("//form[@class='form-address-edit']//input[@name='default_shipping']"); // stepKey: checkUseAsDefaultShippingAddressCheckBoxAddNewDefaultAddress
		$I->click("//button[@title='Save Address']"); // stepKey: saveCustomerAddressAddNewDefaultAddress
		$I->waitForPageLoad(30); // stepKey: saveCustomerAddressAddNewDefaultAddressWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddNewDefaultAddress
		$I->see("You saved the address."); // stepKey: verifyAddressAddedAddNewDefaultAddress
		$I->comment("Exiting Action Group [addNewDefaultAddress] StorefrontAddCustomerDefaultAddressActionGroup");
		$I->comment("Open Customer edit page");
		$I->comment("Entering Action Group [signOutAfterLoggedInAsCustomer] StorefrontSignOutAndCloseTabActionGroup");
		$I->click(".customer-name"); // stepKey: clickCustomerButtonSignOutAfterLoggedInAsCustomer
		$I->waitForElementVisible("div.customer-menu  li.authorization-link", 30); // stepKey: waitForSignOutSignOutAfterLoggedInAsCustomer
		$I->click("div.customer-menu  li.authorization-link"); // stepKey: clickToSignOutSignOutAfterLoggedInAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSignOutAfterLoggedInAsCustomer
		$I->see("You are signed out"); // stepKey: signOutSignOutAfterLoggedInAsCustomer
		$I->closeTab(); // stepKey: closeTabSignOutAfterLoggedInAsCustomer
		$I->comment("Exiting Action Group [signOutAfterLoggedInAsCustomer] StorefrontSignOutAndCloseTabActionGroup");
		$I->comment("Entering Action Group [openCustomerEditPage] AdminOpenCustomerEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createCustomer', 'id', 'test')); // stepKey: openCustomerEditPageOpenCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomerEditPage
		$I->comment("Exiting Action Group [openCustomerEditPage] AdminOpenCustomerEditPageActionGroup");
		$I->comment("Assert Customer Default Billing Address");
		$I->comment("Entering Action Group [checkDefaultBilling] AdminAssertCustomerDefaultBillingAddress");
		$I->click("//span[text()='Addresses']"); // stepKey: proceedToAddressesCheckDefaultBilling
		$I->waitForPageLoad(30); // stepKey: proceedToAddressesCheckDefaultBillingWaitForPageLoad
		$I->see($I->retrieveEntityField('createCustomer', 'firstname', 'test'), "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: firstNameCheckDefaultBilling
		$I->see($I->retrieveEntityField('createCustomer', 'lastname', 'test'), "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: lastNameCheckDefaultBilling
		$I->see("7700 West Parmer Lane", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: street1CheckDefaultBilling
		$I->see("California", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: stateCheckDefaultBilling
		$I->see("90001", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: postcodeCheckDefaultBilling
		$I->see("United States", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: countryCheckDefaultBilling
		$I->see("512-345-6789", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: telephoneCheckDefaultBilling
		$I->comment("Exiting Action Group [checkDefaultBilling] AdminAssertCustomerDefaultBillingAddress");
		$I->comment("Assert Customer Default Shipping Address");
		$I->comment("Entering Action Group [checkDefaultShipping] AdminAssertCustomerDefaultShippingAddress");
		$I->click("//span[text()='Addresses']"); // stepKey: proceedToAddressesCheckDefaultShipping
		$I->waitForPageLoad(30); // stepKey: proceedToAddressesCheckDefaultShippingWaitForPageLoad
		$I->see($I->retrieveEntityField('createCustomer', 'firstname', 'test'), "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: firstNameCheckDefaultShipping
		$I->see($I->retrieveEntityField('createCustomer', 'lastname', 'test'), "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: lastNameCheckDefaultShipping
		$I->see("7700 West Parmer Lane", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: street1CheckDefaultShipping
		$I->see("California", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: stateCheckDefaultShipping
		$I->see("90001", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: postcodeCheckDefaultShipping
		$I->see("United States", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: countryCheckDefaultShipping
		$I->see("512-345-6789", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: telephoneCheckDefaultShipping
		$I->comment("Exiting Action Group [checkDefaultShipping] AdminAssertCustomerDefaultShippingAddress");
	}
}
