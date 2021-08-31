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
 * @Title("MC-5309: Create customer, from USA")
 * @Description("Login as admin and create customer with USA address<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminCreateCustomerWithCountryUSATest.xml<br>")
 * @TestCaseId("MC-5309")
 * @group mtf_migrated
 */
class AdminCreateCustomerWithCountryUSATestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->createEntity("createCustomer", "hook", "Simple_Customer_Without_Address", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Stories({"Create customer"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Customer"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCustomerWithCountryUSATest(AcceptanceTester $I)
	{
		$I->comment("Filter the customer From grid");
		$I->comment("Entering Action Group [filterTheCustomerByEmail] AdminFilterCustomerByEmail");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomerIndexPageFilterTheCustomerByEmail
		$I->waitForPageLoad(30); // stepKey: waitToCustomerIndexPageToLoadFilterTheCustomerByEmail
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerIndexPageFilterTheCustomerByEmail
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerIndexPageFilterTheCustomerByEmailWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetFilterTheCustomerByEmail
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetFilterTheCustomerByEmailWaitForPageLoad
		$I->fillField("input[name=email]", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailFilterTheCustomerByEmail
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterFilterTheCustomerByEmail
		$I->waitForPageLoad(30); // stepKey: applyFilterFilterTheCustomerByEmailWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFilterTheCustomerByEmail
		$I->comment("Exiting Action Group [filterTheCustomerByEmail] AdminFilterCustomerByEmail");
		$I->comment("Entering Action Group [clickOnEditButton] AdminClickFirstRowEditLinkOnCustomerGridActionGroup");
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickOnEditLinkClickOnEditButton
		$I->waitForPageLoad(30); // stepKey: clickOnEditLinkClickOnEditButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadingClickOnEditButton
		$I->comment("Exiting Action Group [clickOnEditButton] AdminClickFirstRowEditLinkOnCustomerGridActionGroup");
		$I->comment("Add the Address");
		$I->click("//span[text()='Addresses']"); // stepKey: selectAddress
		$I->waitForPageLoad(30); // stepKey: selectAddressWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddressPageToLoad
		$I->click("//span[text()='Add New Address']"); // stepKey: ClickOnAddNewAddressButton
		$I->waitForPageLoad(30); // stepKey: waitForNewAddressPageToLoad
		$I->checkOption("div[data-index=default_billing] .admin__actions-switch-label"); // stepKey: EnableDefaultBillingAddress
		$I->fillField("input[name='street[0]']", "[\"7700 West Parmer Lane\",\"113\"]"); // stepKey: fillStreetAddress
		$I->fillField("//*[@class='modal-component']//input[@name='city']", "Los Angeles"); // stepKey: fillCity
		$I->scrollTo("//*[@class='modal-component']//input[@name='telephone']", 0, -80); // stepKey: scrollToPhone
		$I->selectOption("//*[@class='modal-component']//select[@name='country_id']", "United States"); // stepKey: fillCountry
		$I->selectOption("//*[@class='modal-component']//select[@name='region_id']", "California"); // stepKey: fillState
		$I->fillField("//*[@class='modal-component']//input[@name='postcode']", "90001"); // stepKey: fillPostCode
		$I->fillField("//*[@class='modal-component']//input[@name='telephone']", "512-345-6789"); // stepKey: fillPhoneNumber
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage
		$I->click("//button[@title='Save']"); // stepKey: clickOnSaveButton
		$I->waitForPageLoad(30); // stepKey: waitForPageToBeSaved
		$I->click("#save"); // stepKey: saveCustomer
		$I->waitForPageLoad(30); // stepKey: saveCustomerWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessage
		$I->comment("Assert Customer in grid");
		$I->comment("Entering Action Group [filterTheCustomerByEmail1] AdminFilterCustomerByEmail");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomerIndexPageFilterTheCustomerByEmail1
		$I->waitForPageLoad(30); // stepKey: waitToCustomerIndexPageToLoadFilterTheCustomerByEmail1
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerIndexPageFilterTheCustomerByEmail1
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerIndexPageFilterTheCustomerByEmail1WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetFilterTheCustomerByEmail1
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetFilterTheCustomerByEmail1WaitForPageLoad
		$I->fillField("input[name=email]", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailFilterTheCustomerByEmail1
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterFilterTheCustomerByEmail1
		$I->waitForPageLoad(30); // stepKey: applyFilterFilterTheCustomerByEmail1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFilterTheCustomerByEmail1
		$I->comment("Exiting Action Group [filterTheCustomerByEmail1] AdminFilterCustomerByEmail");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad
		$I->see($I->retrieveEntityField('createCustomer', 'firstname', 'test'), "table[data-role='grid']"); // stepKey: assertFirstName
		$I->see($I->retrieveEntityField('createCustomer', 'lastname', 'test'), "table[data-role='grid']"); // stepKey: assertLastName
		$I->see($I->retrieveEntityField('createCustomer', 'email', 'test'), "table[data-role='grid']"); // stepKey: assertEmail
		$I->see("California", "table[data-role='grid']"); // stepKey: assertState
		$I->see("United States", "table[data-role='grid']"); // stepKey: assertCountry
		$I->see("90001", "table[data-role='grid']"); // stepKey: assertPostCode
		$I->see("512-345-6789", "table[data-role='grid']"); // stepKey: assertPhoneNumber
		$I->comment("Assert Customer Form");
		$I->comment("Entering Action Group [clickOnEditButton1] AdminClickFirstRowEditLinkOnCustomerGridActionGroup");
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickOnEditLinkClickOnEditButton1
		$I->waitForPageLoad(30); // stepKey: clickOnEditLinkClickOnEditButton1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadingClickOnEditButton1
		$I->comment("Exiting Action Group [clickOnEditButton1] AdminClickFirstRowEditLinkOnCustomerGridActionGroup");
		$I->click("//a/span[text()='Account Information']"); // stepKey: clickOnAccountInformation
		$I->waitForPageLoad(30); // stepKey: waitForCustomerInformationPageToLoad
		$I->seeInField("input[name='customer[firstname]']", $I->retrieveEntityField('createCustomer', 'firstname', 'test')); // stepKey: seeCustomerFirstName
		$I->seeInField("input[name='customer[lastname]']", $I->retrieveEntityField('createCustomer', 'lastname', 'test')); // stepKey: seeCustomerLastName
		$I->seeInField("input[name='customer[email]']", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: seeCustomerEmail
		$I->click("//a//span[contains(text(), 'Addresses')]"); // stepKey: clickOnAddressButton
		$I->waitForPageLoad(30); // stepKey: waitForAddressGridToLoad
		$I->see($I->retrieveEntityField('createCustomer', 'firstname', 'test'), "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: seeAFirstNameInDefaultAddressSection
		$I->see($I->retrieveEntityField('createCustomer', 'lastname', 'test'), "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: seeLastNameInDefaultAddressSection
		$I->see("[\"7700 West Parmer Lane\",\"113\"]", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: seeStreetInDefaultAddressSection
		$I->see("Los Angeles", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: seeLCityInDefaultAddressSection
		$I->see("United States", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: seeCountrynDefaultAddressSection
		$I->see("90001", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: seePostCodeInDefaultAddressSection
		$I->see("512-345-6789", "//div[@class='customer-default-billing-address-content']//div[@class='address_details']"); // stepKey: seePhoneNumberInDefaultAddressSection
		$I->comment("Assert Customer Address Grid");
		$I->conditionalClick(".admin__data-grid-header .admin__data-grid-filters-current button.action-clear", ".admin__data-grid-header .admin__data-grid-filters-current button.action-clear", true); // stepKey: clearAddressesGridFilter
		$I->waitForPageLoad(30); // stepKey: clearAddressesGridFilterWaitForPageLoad
		$I->see("[\"7700 West Parmer Lane\",\"113\"]", "table[data-role='grid']"); // stepKey: seeStreetAddress
		$I->see("Los Angeles", "table[data-role='grid']"); // stepKey: seeCity
		$I->see("United States", "table[data-role='grid']"); // stepKey: seeCountry
		$I->see("California", "table[data-role='grid']"); // stepKey: seeState
		$I->see("90001", "table[data-role='grid']"); // stepKey: seePostCode
		$I->see("512-345-6789", "table[data-role='grid']"); // stepKey: seePhoneNumber
	}
}
