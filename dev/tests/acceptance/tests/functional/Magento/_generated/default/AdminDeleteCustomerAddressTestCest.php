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
 * @Title("MC-13623: Delete Customer Address in Admin")
 * @Description("Delete Customer Address in Admin<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminUpdateCustomerTest/AdminDeleteCustomerAddressTest.xml<br>")
 * @TestCaseId("MC-13623")
 * @group Customer
 * @group mtf_migrated
 */
class AdminDeleteCustomerAddressTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("customer", "hook", "Simple_US_Customer_Multiple_Addresses", [], []); // stepKey: customer
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
	 * @Features({"Customer"})
	 * @Stories({"Delete Customer Address in Admin"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteCustomerAddressTest(AcceptanceTester $I)
	{
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('customer', 'id', 'test') . "/"); // stepKey: openCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: waitForCustomerEditPage
		$I->comment("Assert Customer Default Billing Address");
		$I->comment("Entering Action Group [checkDefaultBilling] AdminAssertCustomerDefaultBillingAddress");
		$I->click("//span[text()='Addresses']"); // stepKey: proceedToAddressesCheckDefaultBilling
		$I->waitForPageLoad(30); // stepKey: proceedToAddressesCheckDefaultBillingWaitForPageLoad
		$I->see($I->retrieveEntityField('customer', 'firstname', 'test'), "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: firstNameCheckDefaultBilling
		$I->see($I->retrieveEntityField('customer', 'lastname', 'test'), "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: lastNameCheckDefaultBilling
		$I->see("368 Broadway St.", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: street1CheckDefaultBilling
		$I->see("New York", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: stateCheckDefaultBilling
		$I->see("10001", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: postcodeCheckDefaultBilling
		$I->see("United States", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: countryCheckDefaultBilling
		$I->see("512-345-6789", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: telephoneCheckDefaultBilling
		$I->comment("Exiting Action Group [checkDefaultBilling] AdminAssertCustomerDefaultBillingAddress");
		$I->comment("Assert Customer Default Shipping Address");
		$I->comment("Entering Action Group [checkDefaultShipping] AdminAssertCustomerDefaultShippingAddress");
		$I->click("//span[text()='Addresses']"); // stepKey: proceedToAddressesCheckDefaultShipping
		$I->waitForPageLoad(30); // stepKey: proceedToAddressesCheckDefaultShippingWaitForPageLoad
		$I->see($I->retrieveEntityField('customer', 'firstname', 'test'), "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: firstNameCheckDefaultShipping
		$I->see($I->retrieveEntityField('customer', 'lastname', 'test'), "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: lastNameCheckDefaultShipping
		$I->see("368 Broadway St.", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: street1CheckDefaultShipping
		$I->see("New York", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: stateCheckDefaultShipping
		$I->see("10001", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: postcodeCheckDefaultShipping
		$I->see("United States", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: countryCheckDefaultShipping
		$I->see("512-345-6789", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: telephoneCheckDefaultShipping
		$I->comment("Exiting Action Group [checkDefaultShipping] AdminAssertCustomerDefaultShippingAddress");
		$I->comment("Entering Action Group [resetFilter] AdminResetFilterInCustomerAddressGrid");
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersResetFilter
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetFilterWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetFilter
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetFilter
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetFilterWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadResetFilter
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetFilter
		$I->comment("Exiting Action Group [resetFilter] AdminResetFilterInCustomerAddressGrid");
		$I->comment("Assert 2 records in Customer Address Grid");
		$I->comment("Entering Action Group [see2Record] AdminAssertNumberOfRecordsInCustomersAddressGrid");
		$I->see("2 records found", ".admin__data-grid-header-row.row.row-gutter"); // stepKey: seeRecordsSee2Record
		$I->comment("Exiting Action Group [see2Record] AdminAssertNumberOfRecordsInCustomersAddressGrid");
		$I->comment("Assert Address 1 in Grid");
		$I->comment("Entering Action Group [checkAddressStreetInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->see("368 Broadway St.", "//tr[contains(@class,'data-row')]"); // stepKey: seeTextInGridCheckAddressStreetInGrid
		$I->comment("Exiting Action Group [checkAddressStreetInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->comment("Entering Action Group [checkAddressPhoneInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->see("512-345-6789", "//tr[contains(@class,'data-row')]"); // stepKey: seeTextInGridCheckAddressPhoneInGrid
		$I->comment("Exiting Action Group [checkAddressPhoneInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->comment("Entering Action Group [checkAddressStateInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->see("New York", "//tr[contains(@class,'data-row')]"); // stepKey: seeTextInGridCheckAddressStateInGrid
		$I->comment("Exiting Action Group [checkAddressStateInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->comment("Entering Action Group [checkAddressCityInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->see("New York", "//tr[contains(@class,'data-row')]"); // stepKey: seeTextInGridCheckAddressCityInGrid
		$I->comment("Exiting Action Group [checkAddressCityInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->comment("Entering Action Group [checkAddressCountryInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->see("United States", "//tr[contains(@class,'data-row')]"); // stepKey: seeTextInGridCheckAddressCountryInGrid
		$I->comment("Exiting Action Group [checkAddressCountryInGrid] AdminAssertAddressInCustomersAddressGrid");
		$I->comment("Assert Address 2 in Grid");
		$I->comment("Entering Action Group [checkAddressStreetInGrid2] AdminAssertAddressInCustomersAddressGrid");
		$I->see("172, Westminster Bridge Rd", "//tr[contains(@class,'data-row')]"); // stepKey: seeTextInGridCheckAddressStreetInGrid2
		$I->comment("Exiting Action Group [checkAddressStreetInGrid2] AdminAssertAddressInCustomersAddressGrid");
		$I->comment("Entering Action Group [checkAddressPhoneInGrid2] AdminAssertAddressInCustomersAddressGrid");
		$I->see("444-44-444-44", "//tr[contains(@class,'data-row')]"); // stepKey: seeTextInGridCheckAddressPhoneInGrid2
		$I->comment("Exiting Action Group [checkAddressPhoneInGrid2] AdminAssertAddressInCustomersAddressGrid");
		$I->comment("Entering Action Group [checkAddressCityInGrid2] AdminAssertAddressInCustomersAddressGrid");
		$I->see("London", "//tr[contains(@class,'data-row')]"); // stepKey: seeTextInGridCheckAddressCityInGrid2
		$I->comment("Exiting Action Group [checkAddressCityInGrid2] AdminAssertAddressInCustomersAddressGrid");
		$I->comment("Delete Customer in Customer Address Grid");
		$I->comment("Entering Action Group [deleteAddress] AdminDeleteAddressInCustomersAddressGrid");
		$I->click("//tr[contains(@data-repeat-index, '0')]//input[contains(@data-action, 'select-row')]"); // stepKey: clickRowCustomerAddressCheckboxDeleteAddress
		$I->click("//tr[contains(@data-repeat-index, '0')]//button[@class='action-select']"); // stepKey: openActionsDropdownDeleteAddress
		$I->click("//tr[contains(@data-repeat-index, '0')]//a[contains(@data-action,'item-delete')]"); // stepKey: chooseDeleteOptionDeleteAddress
		$I->waitForPageLoad(30); // stepKey: chooseDeleteOptionDeleteAddressWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerAddressesGridPageLoadDeleteAddress
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: clickOkOnPopupDeleteAddress
		$I->waitForPageLoad(30); // stepKey: clickOkOnPopupDeleteAddressWaitForPageLoad
		$I->comment("Exiting Action Group [deleteAddress] AdminDeleteAddressInCustomersAddressGrid");
		$I->comment("Assert 1 record in Customer Address Grid");
		$I->comment("Entering Action Group [see1Record] AdminAssertNumberOfRecordsInCustomersAddressGrid");
		$I->see("1 records found", ".admin__data-grid-header-row.row.row-gutter"); // stepKey: seeRecordsSee1Record
		$I->comment("Exiting Action Group [see1Record] AdminAssertNumberOfRecordsInCustomersAddressGrid");
		$I->comment("Entering Action Group [saveAndContinue] AdminCustomerSaveAndContinue");
		$I->click("#save_and_continue"); // stepKey: saveAndContinueSaveAndContinue
		$I->waitForPageLoad(30); // stepKey: saveAndContinueSaveAndContinueWaitForPageLoad
		$I->comment("Exiting Action Group [saveAndContinue] AdminCustomerSaveAndContinue");
		$I->comment("Entering Action Group [saveAndCheckSuccessMessage] AdminSaveCustomerAndAssertSuccessMessage");
		$I->click("#save"); // stepKey: saveCustomerSaveAndCheckSuccessMessage
		$I->waitForPageLoad(30); // stepKey: saveCustomerSaveAndCheckSuccessMessageWaitForPageLoad
		$I->see("You saved the customer", ".message-success"); // stepKey: seeMessageSaveAndCheckSuccessMessage
		$I->comment("Exiting Action Group [saveAndCheckSuccessMessage] AdminSaveCustomerAndAssertSuccessMessage");
		$I->comment("Assert Customer Login Storefront");
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
		$I->comment("Assert Customer Address Book");
		$I->comment("Entering Action Group [goToAddressBook] StorefrontCustomerGoToSidebarMenu");
		$I->click("//div[@id='block-collapsible-nav']//a[text()='Address Book']"); // stepKey: goToAddressBookGoToAddressBook
		$I->waitForPageLoad(60); // stepKey: goToAddressBookGoToAddressBookWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToAddressBook
		$I->comment("Exiting Action Group [goToAddressBook] StorefrontCustomerGoToSidebarMenu");
		$I->comment("Entering Action Group [assertAddressNumber] StorefrontCustomerAddressBookNumberOfAddresses");
		$I->see("1 Item", ".toolbar-number"); // stepKey: checkNumberOfAddressesAssertAddressNumber
		$I->comment("Exiting Action Group [assertAddressNumber] StorefrontCustomerAddressBookNumberOfAddresses");
		$I->comment("Entering Action Group [assertNoAddress1] StorefrontCustomerAddressBookNotContains");
		$I->dontSee("368 Broadway St.", ".additional-addresses"); // stepKey: doesNotContainsTextAssertNoAddress1
		$I->comment("Exiting Action Group [assertNoAddress1] StorefrontCustomerAddressBookNotContains");
		$I->comment("Entering Action Group [assertAddress2] StorefrontCustomerAddressBookContains");
		$I->see("172, Westminster Bridge Rd", ".additional-addresses"); // stepKey: containsTextAssertAddress2
		$I->comment("Exiting Action Group [assertAddress2] StorefrontCustomerAddressBookContains");
	}
}
