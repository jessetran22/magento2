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
 * @Title("[NO TESTCASEID]: Place an order when country allowed only on current website")
 * @Description("Place an order when country allowed only on current website scope<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminPlaceOrderWhenCountryAllowedOnlyOnCurrentWebsiteScopeTest.xml<br>")
 * @group customer
 */
class AdminPlaceOrderWhenCountryAllowedOnlyOnCurrentWebsiteScopeTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$setAllowedCountryUs = $I->magentoCLI("config:set --scope=websites --scope-code=base general/country/allow US", 60); // stepKey: setAllowedCountryUs
		$I->comment($setAllowedCountryUs);
		$unselectAllCountriesFromAllowedCounties = $I->magentoCLI("config:set general/country/allow ''", 60); // stepKey: unselectAllCountriesFromAllowedCounties
		$I->comment($unselectAllCountriesFromAllowedCounties);
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
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
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->createEntity("setDefaultValueForAllowCountries", "hook", "DisableAdminAccountAllowCountry", [], []); // stepKey: setDefaultValueForAllowCountries
		$I->createEntity("setDefaultValueForAllowCountriesForDefaultWebsites", "hook", "SetAdminAccountAllowCountryToDefaultForDefaultWebsite", [], []); // stepKey: setDefaultValueForAllowCountriesForDefaultWebsites
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
	 * @Stories({"Customer Order"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminPlaceOrderWhenCountryAllowedOnlyOnCurrentWebsiteScopeTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToNewOrderWithExistingCustomer] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadNavigateToNewOrderWithExistingCustomer
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleNavigateToNewOrderWithExistingCustomer
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderNavigateToNewOrderWithExistingCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGridLoadNavigateToNewOrderWithExistingCustomer
		$I->comment("Clear grid filters");
		$I->conditionalClick("#sales_order_create_customer_grid [data-action='grid-filter-reset']", "#sales_order_create_customer_grid [data-action='grid-filter-reset']", true); // stepKey: clearExistingCustomerFiltersNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: clearExistingCustomerFiltersNavigateToNewOrderWithExistingCustomerWaitForPageLoad
		$I->fillField("#sales_order_create_customer_grid_filter_email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailNavigateToNewOrderWithExistingCustomer
		$I->click(".action-secondary[title='Search']"); // stepKey: applyFilterNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForFilteredCustomerGridLoadNavigateToNewOrderWithExistingCustomer
		$I->click("tr:nth-of-type(1)[data-role='row']"); // stepKey: clickOnCustomerNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadNavigateToNewOrderWithExistingCustomer
		$I->comment("Select store view if appears");
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderWithExistingCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectNavigateToNewOrderWithExistingCustomer
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleNavigateToNewOrderWithExistingCustomer
		$I->comment("Exiting Action Group [navigateToNewOrderWithExistingCustomer] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->comment("Entering Action Group [addSimpleProductToTheOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddSimpleProductToTheOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddSimpleProductToTheOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddSimpleProductToTheOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddSimpleProductToTheOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddSimpleProductToTheOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddSimpleProductToTheOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddSimpleProductToTheOrder
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "2"); // stepKey: fillProductQtyAddSimpleProductToTheOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddSimpleProductToTheOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddSimpleProductToTheOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddSimpleProductToTheOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddSimpleProductToTheOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddSimpleProductToTheOrder
		$I->comment("Exiting Action Group [addSimpleProductToTheOrder] AddSimpleProductToOrderActionGroup");
		$I->comment("Entering Action Group [selectFlatRateShippingMethod] AdminSelectFlatRateShippingMethodActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoadSelectFlatRateShippingMethod
		$I->click("//span[text()='Get shipping methods and rates']"); // stepKey: openShippingMethodSelectFlatRateShippingMethod
		$I->waitForPageLoad(60); // stepKey: openShippingMethodSelectFlatRateShippingMethodWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodsSelectFlatRateShippingMethod
		$I->click("//label[contains(text(), 'Fixed')]"); // stepKey: chooseShippingMethodSelectFlatRateShippingMethod
		$I->waitForPageLoad(60); // stepKey: chooseShippingMethodSelectFlatRateShippingMethodWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSelectFlatRateShippingMethod
		$I->comment("Exiting Action Group [selectFlatRateShippingMethod] AdminSelectFlatRateShippingMethodActionGroup");
		$I->comment("Entering Action Group [submitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->click("#submit_order_top_button"); // stepKey: clickSubmitOrderSubmitOrder
		$I->waitForPageLoad(30); // stepKey: clickSubmitOrderSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoadSubmitOrder
		$I->comment("Exiting Action Group [submitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->comment("Entering Action Group [verifyCreatedOrderInformation] VerifyCreatedOrderInformationActionGroup");
		$I->see("You created the order.", "div.message-success"); // stepKey: seeSuccessMessageVerifyCreatedOrderInformation
		$I->see("Pending", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderPendingStatusVerifyCreatedOrderInformation
		$getOrderIdVerifyCreatedOrderInformation = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: getOrderIdVerifyCreatedOrderInformation
		$I->assertNotEmpty($getOrderIdVerifyCreatedOrderInformation); // stepKey: assertOrderIdIsNotEmptyVerifyCreatedOrderInformation
		$I->comment("Exiting Action Group [verifyCreatedOrderInformation] VerifyCreatedOrderInformationActionGroup");
	}
}
