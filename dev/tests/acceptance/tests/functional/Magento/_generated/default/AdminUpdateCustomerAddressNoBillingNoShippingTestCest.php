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
 * @Title("MC-13622: Update Customer Address, default billing/shipping unchecked in Admin")
 * @Description("Update Customer Address, default billing/shipping unchecked in Admin<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminUpdateCustomerTest/AdminUpdateCustomerAddressNoBillingNoShippingTest.xml<br>")
 * @TestCaseId("MC-13622")
 * @group Customer
 * @group mtf_migrated
 */
class AdminUpdateCustomerAddressNoBillingNoShippingTestCest
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
	public function AdminUpdateCustomerAddressNoBillingNoShippingTest(AcceptanceTester $I)
	{
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('customer', 'id', 'test') . "/"); // stepKey: openCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: waitForCustomerEditPage
		$I->comment("Update Customer Account Information");
		$I->comment("Update Customer Addresses");
		$I->comment("Entering Action Group [editCustomerAddress] AdminEditCustomerAddressesFromActionGroup");
		$I->click("//span[text()='Addresses']"); // stepKey: proceedToAddressesEditCustomerAddress
		$I->waitForPageLoad(30); // stepKey: proceedToAddressesEditCustomerAddressWaitForPageLoad
		$I->click("//span[text()='Add New Address']"); // stepKey: addNewAddressesEditCustomerAddress
		$I->waitForPageLoad(60); // stepKey: wait5678EditCustomerAddress
		$I->fillField("input[name='prefix']", "Mr"); // stepKey: fillPrefixNameEditCustomerAddress
		$I->fillField("input[name='middlename']", "string"); // stepKey: fillMiddleNameEditCustomerAddress
		$I->fillField("input[name='suffix']", "Sr"); // stepKey: fillSuffixNameEditCustomerAddress
		$I->fillField("input[name='company']", "Magento"); // stepKey: fillCompanyEditCustomerAddress
		$I->fillField("input[name='street[0]']", "7700 W Parmer Ln"); // stepKey: fillStreetAddressEditCustomerAddress
		$I->fillField("//*[@class='modal-component']//input[@name='city']", "Austin"); // stepKey: fillCityEditCustomerAddress
		$I->selectOption("//*[@class='modal-component']//select[@name='country_id']", "US"); // stepKey: selectCountryEditCustomerAddress
		$I->selectOption("//*[@class='modal-component']//select[@name='region_id']", "Texas"); // stepKey: selectStateEditCustomerAddress
		$I->fillField("//*[@class='modal-component']//input[@name='postcode']", "78729"); // stepKey: fillZipCodeEditCustomerAddress
		$I->fillField("//*[@class='modal-component']//input[@name='telephone']", "1234568910"); // stepKey: fillPhoneEditCustomerAddress
		$I->fillField("input[name='vat_id']", "vatData"); // stepKey: fillVATEditCustomerAddress
		$I->click("//button[@title='Save']"); // stepKey: saveAddressEditCustomerAddress
		$I->waitForPageLoad(30); // stepKey: waitForAddressSavedEditCustomerAddress
		$I->comment("Exiting Action Group [editCustomerAddress] AdminEditCustomerAddressesFromActionGroup");
		$I->comment("Entering Action Group [saveAndCheckSuccessMessage] AdminSaveCustomerAndAssertSuccessMessage");
		$I->click("#save"); // stepKey: saveCustomerSaveAndCheckSuccessMessage
		$I->waitForPageLoad(30); // stepKey: saveCustomerSaveAndCheckSuccessMessageWaitForPageLoad
		$I->see("You saved the customer", ".message-success"); // stepKey: seeMessageSaveAndCheckSuccessMessage
		$I->comment("Exiting Action Group [saveAndCheckSuccessMessage] AdminSaveCustomerAndAssertSuccessMessage");
		$I->comment("Assert Customer in Customer Form");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('customer', 'id', 'test') . "/"); // stepKey: openCustomerEditPageAfterSave
		$I->waitForPageLoad(30); // stepKey: waitForCustomerEditPageAfterSave
		$I->comment("Entering Action Group [checkNoDefaultBilling] AdminAssertCustomerNoDefaultBillingAddress");
		$I->click("//span[text()='Addresses']"); // stepKey: proceedToAddressesCheckNoDefaultBilling
		$I->waitForPageLoad(30); // stepKey: proceedToAddressesCheckNoDefaultBillingWaitForPageLoad
		$I->see("The customer does not have default billing address", "//div[@class='customer-default-billing-address-content']//address//span"); // stepKey: seeCheckNoDefaultBilling
		$I->comment("Exiting Action Group [checkNoDefaultBilling] AdminAssertCustomerNoDefaultBillingAddress");
		$I->comment("Entering Action Group [checkNoDefaultShipping] AdminAssertCustomerNoDefaultShippingAddress");
		$I->click("//span[text()='Addresses']"); // stepKey: proceedToAddressesCheckNoDefaultShipping
		$I->waitForPageLoad(30); // stepKey: proceedToAddressesCheckNoDefaultShippingWaitForPageLoad
		$I->see("The customer does not have default shipping address", "//div[@class='customer-default-shipping-address-content']//address//span"); // stepKey: seeCheckNoDefaultShipping
		$I->comment("Exiting Action Group [checkNoDefaultShipping] AdminAssertCustomerNoDefaultShippingAddress");
		$I->comment("Entering Action Group [resetFilter] AdminResetFilterInCustomerAddressGrid");
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersResetFilter
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetFilterWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetFilter
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetFilter
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetFilterWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadResetFilter
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetFilter
		$I->comment("Exiting Action Group [resetFilter] AdminResetFilterInCustomerAddressGrid");
		$I->comment("Entering Action Group [searchAddress] AdminFilterCustomerAddressGridByPhoneNumber");
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersSearchAddress
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchAddressWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSearchAddress
		$I->waitForPageLoad(30); // stepKey: openFiltersSearchAddressWaitForPageLoad
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: fillSearchAddress
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersSearchAddress
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersSearchAddressWaitForPageLoad
		$I->comment("Exiting Action Group [searchAddress] AdminFilterCustomerAddressGridByPhoneNumber");
		$I->comment("Entering Action Group [checkAddressStreetInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->see("7700 W Parmer Ln", "//tr[contains(@class,'data-row')]"); // stepKey: seeTextInGridCheckAddressStreetInGrid
		$I->comment("Exiting Action Group [checkAddressStreetInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->comment("Entering Action Group [checkAddressPhoneInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->see("1234568910", "//tr[contains(@class,'data-row')]"); // stepKey: seeTextInGridCheckAddressPhoneInGrid
		$I->comment("Exiting Action Group [checkAddressPhoneInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->comment("Entering Action Group [checkAddressStateInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->see("Texas", "//tr[contains(@class,'data-row')]"); // stepKey: seeTextInGridCheckAddressStateInGrid
		$I->comment("Exiting Action Group [checkAddressStateInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->comment("Entering Action Group [checkAddressCityInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->see("Austin", "//tr[contains(@class,'data-row')]"); // stepKey: seeTextInGridCheckAddressCityInGrid
		$I->comment("Exiting Action Group [checkAddressCityInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->comment("Entering Action Group [checkAddressCountryInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->see("US", "//tr[contains(@class,'data-row')]"); // stepKey: seeTextInGridCheckAddressCountryInGrid
		$I->comment("Exiting Action Group [checkAddressCountryInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->comment("Entering Action Group [resetFilterWhenDone] AdminResetFilterInCustomerAddressGrid");
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersResetFilterWhenDone
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetFilterWhenDoneWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetFilterWhenDone
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetFilterWhenDone
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetFilterWhenDoneWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadResetFilterWhenDone
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetFilterWhenDone
		$I->comment("Exiting Action Group [resetFilterWhenDone] AdminResetFilterInCustomerAddressGrid");
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
		$I->comment("Assert Customer Account Information");
		$I->comment("Assert Customer Default Billing Address");
		$I->comment("Assert Customer Default Shipping Address");
		$I->comment("Remove steps that are not used for this test");
		$I->comment("Update Customer Addresses With Default Billing and Shipping Unchecked");
		$I->comment("Check Customer Address in Customer Form");
		$I->comment("Assert Customer Login Storefront");
	}
}
