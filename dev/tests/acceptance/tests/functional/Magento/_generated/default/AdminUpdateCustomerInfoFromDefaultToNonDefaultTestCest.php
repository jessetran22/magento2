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
 * @Title("MC-13619: Update Customer Info from Default to Non-Default in Admin")
 * @Description("Update Customer Info from Default to Non-Default in Admin<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminUpdateCustomerTest/AdminUpdateCustomerInfoFromDefaultToNonDefaultTest.xml<br>")
 * @TestCaseId("MC-13619")
 * @group Customer
 * @group mtf_migrated
 */
class AdminUpdateCustomerInfoFromDefaultToNonDefaultTestCest
{
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
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [goToCustomersGridPage] AdminOpenCustomersGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomersGridPageGoToCustomersGridPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToCustomersGridPage
		$I->comment("Exiting Action Group [goToCustomersGridPage] AdminOpenCustomersGridActionGroup");
		$I->comment("Entering Action Group [resetFilter] AdminResetFilterInCustomerGrid");
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersResetFilter
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetFilterWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetFilter
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetFilter
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetFilterWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadResetFilter
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetFilter
		$I->comment("Exiting Action Group [resetFilter] AdminResetFilterInCustomerGrid");
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
	 * @Stories({"Update Customer Information in Admin"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateCustomerInfoFromDefaultToNonDefaultTest(AcceptanceTester $I)
	{
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('customer', 'id', 'test') . "/"); // stepKey: openCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: waitForCustomerEditPage
		$I->comment("Update Customer Account Information");
		$I->comment("Entering Action Group [editCustomerInformation] AdminEditCustomerAccountInformationActionGroup");
		$I->click("#tab_customer"); // stepKey: goToAccountInformationEditCustomerInformation
		$I->waitForPageLoad(30); // stepKey: goToAccountInformationEditCustomerInformationWaitForPageLoad
		$I->clearField("input[name='customer[firstname]']"); // stepKey: clearFirstNameEditCustomerInformation
		$I->fillField("input[name='customer[firstname]']", $I->retrieveEntityField('customer', 'firstname', 'test') . "updated"); // stepKey: fillFirstNameEditCustomerInformation
		$I->clearField("input[name='customer[lastname]']"); // stepKey: clearLastNameEditCustomerInformation
		$I->fillField("input[name='customer[lastname]']", $I->retrieveEntityField('customer', 'lastname', 'test') . "updated"); // stepKey: fillLastNameEditCustomerInformation
		$I->clearField("input[name='customer[email]']"); // stepKey: clearEmailEditCustomerInformation
		$I->fillField("input[name='customer[email]']", "updated" . $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailEditCustomerInformation
		$I->click("#save_and_continue"); // stepKey: saveAndContinueEditCustomerInformation
		$I->waitForPageLoad(30); // stepKey: saveAndContinueEditCustomerInformationWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitEditCustomerInformation
		$I->scrollToTopOfPage(); // stepKey: scrollToTopEditCustomerInformation
		$I->comment("Exiting Action Group [editCustomerInformation] AdminEditCustomerAccountInformationActionGroup");
		$I->comment("Update Customer Addresses");
		$I->comment("Entering Action Group [editCustomerAddress] AdminEditCustomerAddressSetDefaultShippingAndBillingActionGroup");
		$I->click("//span[text()='Addresses']"); // stepKey: proceedToAddressesEditCustomerAddress
		$I->waitForPageLoad(30); // stepKey: proceedToAddressesEditCustomerAddressWaitForPageLoad
		$I->click("//span[text()='Add New Address']"); // stepKey: addNewAddressesEditCustomerAddress
		$I->waitForPageLoad(60); // stepKey: wait5678EditCustomerAddress
		$I->click("//input[@name='default_billing']/following-sibling::label"); // stepKey: setDefaultBillingEditCustomerAddress
		$I->click("//input[@name='default_shipping']/following-sibling::label"); // stepKey: setDefaultShippingEditCustomerAddress
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
		$I->comment("Exiting Action Group [editCustomerAddress] AdminEditCustomerAddressSetDefaultShippingAndBillingActionGroup");
		$I->comment("Entering Action Group [saveAndCheckSuccessMessage] AdminSaveCustomerAndAssertSuccessMessage");
		$I->click("#save"); // stepKey: saveCustomerSaveAndCheckSuccessMessage
		$I->waitForPageLoad(30); // stepKey: saveCustomerSaveAndCheckSuccessMessageWaitForPageLoad
		$I->see("You saved the customer", ".message-success"); // stepKey: seeMessageSaveAndCheckSuccessMessage
		$I->comment("Exiting Action Group [saveAndCheckSuccessMessage] AdminSaveCustomerAndAssertSuccessMessage");
		$I->comment("Entering Action Group [goToCustomersGridPage] AdminOpenCustomersGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomersGridPageGoToCustomersGridPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToCustomersGridPage
		$I->comment("Exiting Action Group [goToCustomersGridPage] AdminOpenCustomersGridActionGroup");
		$I->comment("Entering Action Group [resetFilter] AdminResetFilterInCustomerGrid");
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersResetFilter
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetFilterWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetFilter
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetFilter
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetFilterWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadResetFilter
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetFilter
		$I->comment("Exiting Action Group [resetFilter] AdminResetFilterInCustomerGrid");
		$I->comment("Entering Action Group [filterByEamil] AdminFilterCustomerGridByEmail");
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersFilterByEamil
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterByEamilWaitForPageLoad
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersFilterByEamil
		$I->waitForPageLoad(30); // stepKey: openFiltersFilterByEamilWaitForPageLoad
		$I->fillField("input[name=email]", "updated" . $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailFilterByEamil
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersFilterByEamil
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterByEamilWaitForPageLoad
		$I->comment("Exiting Action Group [filterByEamil] AdminFilterCustomerGridByEmail");
		$I->comment("Entering Action Group [checkCustomerInGrid] AdminAssertCustomerInCustomersGrid");
		$I->see("updated" . $I->retrieveEntityField('customer', 'email', 'test'), "//*[@data-role='sticky-el-root']/parent::div/parent::div/following-sibling::div//tbody//*[@class='data-row'][1]"); // stepKey: seeCustomerInGridCheckCustomerInGrid
		$I->comment("Exiting Action Group [checkCustomerInGrid] AdminAssertCustomerInCustomersGrid");
		$I->comment("Assert Customer in Customer Form");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('customer', 'id', 'test') . "/"); // stepKey: openCustomerEditPageAfterSave
		$I->waitForPageLoad(30); // stepKey: waitForCustomerEditPageAfterSave
		$I->comment("Assert Customer Account Information");
		$I->comment("Entering Action Group [checkCustomerAccountInformation] AdminAssertCustomerAccountInformation");
		$I->click("#tab_customer"); // stepKey: proceedToAccountInformationCheckCustomerAccountInformation
		$I->waitForPageLoad(30); // stepKey: proceedToAccountInformationCheckCustomerAccountInformationWaitForPageLoad
		$I->seeInField("input[name='customer[firstname]']", $I->retrieveEntityField('customer', 'firstname', 'test') . "updated"); // stepKey: firstNameCheckCustomerAccountInformation
		$I->seeInField("input[name='customer[lastname]']", $I->retrieveEntityField('customer', 'lastname', 'test') . "updated"); // stepKey: lastNameCheckCustomerAccountInformation
		$I->seeInField("input[name='customer[email]']", "updated" . $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: emailCheckCustomerAccountInformation
		$I->comment("Exiting Action Group [checkCustomerAccountInformation] AdminAssertCustomerAccountInformation");
		$I->comment("Assert Customer Default Billing Address");
		$I->comment("Entering Action Group [checkDefaultBilling] AdminAssertCustomerDefaultBillingAddress");
		$I->click("//span[text()='Addresses']"); // stepKey: proceedToAddressesCheckDefaultBilling
		$I->waitForPageLoad(30); // stepKey: proceedToAddressesCheckDefaultBillingWaitForPageLoad
		$I->see($I->retrieveEntityField('customer', 'firstname', 'test') . "updated", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: firstNameCheckDefaultBilling
		$I->see($I->retrieveEntityField('customer', 'lastname', 'test') . "updated", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: lastNameCheckDefaultBilling
		$I->see("7700 W Parmer Ln", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: street1CheckDefaultBilling
		$I->see("Texas", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: stateCheckDefaultBilling
		$I->see("78729", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: postcodeCheckDefaultBilling
		$I->see("US", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: countryCheckDefaultBilling
		$I->see("1234568910", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: telephoneCheckDefaultBilling
		$I->comment("Exiting Action Group [checkDefaultBilling] AdminAssertCustomerDefaultBillingAddress");
		$I->comment("Assert Customer Default Shipping Address");
		$I->comment("Entering Action Group [checkDefaultShipping] AdminAssertCustomerDefaultShippingAddress");
		$I->click("//span[text()='Addresses']"); // stepKey: proceedToAddressesCheckDefaultShipping
		$I->waitForPageLoad(30); // stepKey: proceedToAddressesCheckDefaultShippingWaitForPageLoad
		$I->see($I->retrieveEntityField('customer', 'firstname', 'test') . "updated", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: firstNameCheckDefaultShipping
		$I->see($I->retrieveEntityField('customer', 'lastname', 'test') . "updated", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: lastNameCheckDefaultShipping
		$I->see("7700 W Parmer Ln", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: street1CheckDefaultShipping
		$I->see("Texas", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: stateCheckDefaultShipping
		$I->see("78729", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: postcodeCheckDefaultShipping
		$I->see("US", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: countryCheckDefaultShipping
		$I->see("1234568910", "//div[@class='customer-default-shipping-address-content']//div[@class='address_details']"); // stepKey: telephoneCheckDefaultShipping
		$I->comment("Exiting Action Group [checkDefaultShipping] AdminAssertCustomerDefaultShippingAddress");
	}
}
