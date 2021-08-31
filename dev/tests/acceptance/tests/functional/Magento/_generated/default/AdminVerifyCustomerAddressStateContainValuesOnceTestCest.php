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
 * @Title("MAGETWO-99461: State/Province dropdown contain values once")
 * @Description("When editing a customer in the backend from the Magento Admin Panel the State/Province should only be listed once<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminVerifyCustomerAddressStateContainValuesOnceTest.xml<br>")
 * @TestCaseId("MAGETWO-99461")
 * @group customer
 */
class AdminVerifyCustomerAddressStateContainValuesOnceTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("firstCustomer", "hook", "Simple_US_Customer_Multiple_Addresses", [], []); // stepKey: firstCustomer
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
		$I->deleteEntity("firstCustomer", "hook"); // stepKey: deleteFirstCustomer
		$I->comment("Entering Action Group [deleteSecondCustomer] AdminDeleteCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersPageDeleteSecondCustomer
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersDeleteSecondCustomer
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteSecondCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersClearDeleteSecondCustomer
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersDeleteSecondCustomer
		$I->waitForPageLoad(30); // stepKey: openFiltersDeleteSecondCustomerWaitForPageLoad
		$I->fillField("input[name=email]", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: fillEmailDeleteSecondCustomer
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersDeleteSecondCustomer
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteSecondCustomerWaitForPageLoad
		$I->click("//*[contains(text(),'" . msq("Simple_US_Customer") . "John.Doe@example.com')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: chooseCustomerDeleteSecondCustomer
		$I->click(".admin__data-grid-header-row .action-select"); // stepKey: openActionsDeleteSecondCustomer
		$I->waitForPageLoad(30); // stepKey: waitActionsDeleteSecondCustomer
		$I->click("//*[contains(@class, 'admin__data-grid-header')]//span[contains(@class,'action-menu-item') and text()='Delete']"); // stepKey: deleteDeleteSecondCustomer
		$I->waitForPageLoad(30); // stepKey: waitForConfirmationAlertDeleteSecondCustomer
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: acceptDeleteSecondCustomer
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteSecondCustomer
		$I->see("A total of 1 record(s) were deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteSecondCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCustomersGridIsLoadedDeleteSecondCustomer
		$I->comment("Exiting Action Group [deleteSecondCustomer] AdminDeleteCustomerActionGroup");
		$I->comment("Entering Action Group [clearFilters] AdminClearCustomersFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: amOnCustomersPageClearFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearFilters
		$I->waitForPageLoad(30); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilters] AdminClearCustomersFiltersActionGroup");
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
	 * @Stories({"Update Customer Address"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminVerifyCustomerAddressStateContainValuesOnceTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openCustomersGridPage] AdminOpenCustomersGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomersGridPageOpenCustomersGridPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomersGridPage
		$I->comment("Exiting Action Group [openCustomersGridPage] AdminOpenCustomersGridActionGroup");
		$I->comment("Select created customer, Click Edit mode");
		$I->comment("Entering Action Group [openEditCustomerPageWithAddresses] OpenEditCustomerFromAdminActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersOpenEditCustomerPageWithAddresses
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1OpenEditCustomerPageWithAddresses
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenEditCustomerPageWithAddresses
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenEditCustomerPageWithAddressesWaitForPageLoad
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFilterOpenEditCustomerPageWithAddresses
		$I->waitForPageLoad(30); // stepKey: openFilterOpenEditCustomerPageWithAddressesWaitForPageLoad
		$I->fillField("input[name=email]", $I->retrieveEntityField('firstCustomer', 'email', 'test')); // stepKey: filterEmailOpenEditCustomerPageWithAddresses
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterOpenEditCustomerPageWithAddresses
		$I->waitForPageLoad(30); // stepKey: applyFilterOpenEditCustomerPageWithAddressesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenEditCustomerPageWithAddresses
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickEditOpenEditCustomerPageWithAddresses
		$I->waitForPageLoad(30); // stepKey: clickEditOpenEditCustomerPageWithAddressesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3OpenEditCustomerPageWithAddresses
		$I->comment("Exiting Action Group [openEditCustomerPageWithAddresses] OpenEditCustomerFromAdminActionGroup");
		$I->comment("Select Addresses tab");
		$I->click("//a[@id='tab_address']"); // stepKey: openAddressesTabOfFirstCustomer
		$I->waitForPageLoad(30); // stepKey: openAddressesTabOfFirstCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddressesOfFirstCustomer
		$I->comment("Click on Edit link for Default Billing Address");
		$I->click("//button[@data-index='edit_billing_address']"); // stepKey: clickEditDefaultBillingAddress
		$I->waitForPageLoad(30); // stepKey: waitForCustomerAddressAddUpdateFormLoad
		$I->comment("Check that State/Province drop down contain all values once");
		$I->seeNumberOfElements("//div[@class='admin__field-control']//select[@name='region_id']//option[@data-title='New York']", "1"); // stepKey: seeOnlyOneRegionInSelectStateForFirstCustomer
		$I->comment("Go to Customers > All customers, Click Add new Customers, fill all necessary fields, Save");
		$I->comment("Entering Action Group [createSimpleUSCustomerWithoutAddress] AdminCreateCustomerWithWebSiteAndGroupActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: goToCustomersPageCreateSimpleUSCustomerWithoutAddress
		$I->click("#add"); // stepKey: addNewCustomerCreateSimpleUSCustomerWithoutAddress
		$I->waitForPageLoad(30); // stepKey: addNewCustomerCreateSimpleUSCustomerWithoutAddressWaitForPageLoad
		$I->selectOption("//select[@name='customer[website_id]']", "Main Website"); // stepKey: selectWebSiteCreateSimpleUSCustomerWithoutAddress
		$I->selectOption("[name='customer[group_id]']", "General"); // stepKey: selectCustomerGroupCreateSimpleUSCustomerWithoutAddress
		$I->fillField("input[name='customer[firstname]']", "John"); // stepKey: FillFirstNameCreateSimpleUSCustomerWithoutAddress
		$I->fillField("input[name='customer[lastname]']", "Doe"); // stepKey: FillLastNameCreateSimpleUSCustomerWithoutAddress
		$I->fillField("input[name='customer[email]']", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: FillEmailCreateSimpleUSCustomerWithoutAddress
		$I->conditionalClick("//input[@name='customer[extension_attributes][assistance_allowed]']/../label", "//input[@name='customer[extension_attributes][assistance_allowed]']/../label", true); // stepKey: clickAllowAssistanceCreateSimpleUSCustomerWithoutAddress
		$I->selectOption("//select[@name='customer[sendemail_store_id]']", "Default Store View"); // stepKey: selectStoreViewCreateSimpleUSCustomerWithoutAddress
		$I->waitForElement("//select[@name='customer[sendemail_store_id]']", 30); // stepKey: waitForCustomerStoreViewExpandCreateSimpleUSCustomerWithoutAddress
		$I->click("//button[@title='Save Customer']"); // stepKey: saveCreateSimpleUSCustomerWithoutAddress
		$I->waitForPageLoad(30); // stepKey: waitForCustomersPageCreateSimpleUSCustomerWithoutAddress
		$I->see("You saved the customer."); // stepKey: seeSuccessMessageCreateSimpleUSCustomerWithoutAddress
		$I->comment("Exiting Action Group [createSimpleUSCustomerWithoutAddress] AdminCreateCustomerWithWebSiteAndGroupActionGroup");
		$I->comment("Select new created customer, Click Edit mode");
		$I->comment("Entering Action Group [openEditCustomerPageWithoutAddresses] OpenEditCustomerFromAdminActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersOpenEditCustomerPageWithoutAddresses
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1OpenEditCustomerPageWithoutAddresses
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenEditCustomerPageWithoutAddresses
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenEditCustomerPageWithoutAddressesWaitForPageLoad
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFilterOpenEditCustomerPageWithoutAddresses
		$I->waitForPageLoad(30); // stepKey: openFilterOpenEditCustomerPageWithoutAddressesWaitForPageLoad
		$I->fillField("input[name=email]", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: filterEmailOpenEditCustomerPageWithoutAddresses
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterOpenEditCustomerPageWithoutAddresses
		$I->waitForPageLoad(30); // stepKey: applyFilterOpenEditCustomerPageWithoutAddressesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenEditCustomerPageWithoutAddresses
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickEditOpenEditCustomerPageWithoutAddresses
		$I->waitForPageLoad(30); // stepKey: clickEditOpenEditCustomerPageWithoutAddressesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3OpenEditCustomerPageWithoutAddresses
		$I->comment("Exiting Action Group [openEditCustomerPageWithoutAddresses] OpenEditCustomerFromAdminActionGroup");
		$I->comment("Select Addresses tab, Click on  create new addresses btn");
		$I->click("//a[@id='tab_address']"); // stepKey: openAddressesTabOfSecondCustomer
		$I->waitForPageLoad(30); // stepKey: openAddressesTabOfSecondCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddressesOfSecondCustomer
		$I->click("//span[text()='Add New Address']"); // stepKey: clickAddNewAddressButton
		$I->waitForPageLoad(30); // stepKey: waitForAddUpdateCustomerAddressForm
		$I->comment("Select Country = United States and check that State/Province drop down contain all values once");
		$I->click("//div[@class='admin__field-control']//select[contains(@name, 'country_id')]"); // stepKey: clickCountryToOpenListOfCountries
		$I->click("//div[@class='admin__field-control']//select[contains(@name, 'country_id')]//option[@value='US']"); // stepKey: fillCountry
		$I->seeNumberOfElements("//div[@class='admin__field-control']//select[@name='region_id']//option[@data-title='New York']", "1"); // stepKey: seeOnlyOneRegionInSelectStateForSecondCustomer
	}
}
