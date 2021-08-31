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
 * @Title("MC-21721: Tax should not be displayed for non taxable address")
 * @Description("Tax should not be displayed for non taxable address when switching from taxable address<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCreateOrderForCustomerWithTwoAddressesTaxableAndNonTaxableTest.xml<br>")
 * @TestCaseId("MC-21721")
 * @group Sales
 */
class AdminCreateOrderForCustomerWithTwoAddressesTaxableAndNonTaxableTestCest
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
		$I->comment("Enable flat rate shipping");
		$enableFlatRate = $I->magentoCLI("config:set carriers/flatrate/active 1", 60); // stepKey: enableFlatRate
		$I->comment($enableFlatRate);
		$I->comment("Enable free shipping method");
		$enableFreeShipping = $I->magentoCLI("config:set carriers/freeshipping/active 1", 60); // stepKey: enableFreeShipping
		$I->comment($enableFreeShipping);
		$I->comment("Create customer");
		$I->createEntity("simpleCustomer", "hook", "Customer_With_Different_Default_Billing_Shipping_Addresses", [], []); // stepKey: simpleCustomer
		$I->comment("Create category");
		$I->createEntity("category1", "hook", "_defaultCategory", [], []); // stepKey: category1
		$I->comment("Create product1");
		$I->createEntity("product1", "hook", "_defaultProduct", ["category1"], []); // stepKey: product1
		$I->comment("Create tax rule for US-CA");
		$I->createEntity("createTaxRule", "hook", "defaultTaxRule", [], []); // stepKey: createTaxRule
		$I->comment("Login as admin");
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
		$I->comment("Delete product1");
		$I->deleteEntity("product1", "hook"); // stepKey: deleteProduct1
		$I->comment("Delete category");
		$I->deleteEntity("category1", "hook"); // stepKey: deleteCategory1
		$I->comment("Delete customer");
		$I->deleteEntity("simpleCustomer", "hook"); // stepKey: deleteSimpleCustomer
		$I->comment("Delete tax rule");
		$I->deleteEntity("createTaxRule", "hook"); // stepKey: deleteTaxRule
		$I->comment("Logout");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Disable free shipping method");
		$disableFreeShipping = $I->magentoCLI("config:set carriers/freeshipping/active 0", 60); // stepKey: disableFreeShipping
		$I->comment($disableFreeShipping);
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
	 * @Stories({"MC-21699: Tax does not change when changing the billing address from Admin Panel"})
	 * @Features({"Sales"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateOrderForCustomerWithTwoAddressesTaxableAndNonTaxableTest(AcceptanceTester $I)
	{
		$I->comment("Step 1: Create new order for customer");
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
		$I->fillField("#sales_order_create_customer_grid_filter_email", $I->retrieveEntityField('simpleCustomer', 'email', 'test')); // stepKey: filterEmailNavigateToNewOrderWithExistingCustomer
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
		$I->comment("Step 2: Add product1 to the order");
		$I->comment("Entering Action Group [addSimpleProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddSimpleProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('product1', 'sku', 'test')); // stepKey: fillSkuFilterAddSimpleProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddSimpleProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddSimpleProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddSimpleProductToOrder
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "1"); // stepKey: fillProductQtyAddSimpleProductToOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddSimpleProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddSimpleProductToOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddSimpleProductToOrder
		$I->comment("Exiting Action Group [addSimpleProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->comment("Step 2: Select taxable address as billing address");
		$I->selectOption("//select[@id='order-billing_address_customer_address_id']", "California"); // stepKey: selectTaxableAddress
		$I->waitForPageLoad(30); // stepKey: waitForChangeBillingAddress
		$I->comment("Step 3: Set shipping address same as billing");
		$I->checkOption("#order-shipping_same_as_billing"); // stepKey: checkSameAsBillingAddressCheckbox
		$I->waitForPageLoad(30); // stepKey: waitForChangeShippingAddress
		$I->comment("Step 3: Select FlatRate shipping method");
		$I->comment("Entering Action Group [selectFlatRateShippingMethod] OrderSelectFlatRateShippingActionGroup");
		$I->click("#order-methods span.title"); // stepKey: unfocusSelectFlatRateShippingMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForJavascriptToFinishSelectFlatRateShippingMethod
		$I->click("#order-shipping_method a.action-default"); // stepKey: clickShippingMethodsSelectFlatRateShippingMethod
		$I->waitForPageLoad(30); // stepKey: clickShippingMethodsSelectFlatRateShippingMethodWaitForPageLoad
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingOptionsSelectFlatRateShippingMethod
		$I->waitForPageLoad(30); // stepKey: waitForShippingOptionsSelectFlatRateShippingMethodWaitForPageLoad
		$I->selectOption("#s_method_flatrate_flatrate", "flatrate_flatrate"); // stepKey: checkFlatRateSelectFlatRateShippingMethod
		$I->waitForPageLoad(30); // stepKey: checkFlatRateSelectFlatRateShippingMethodWaitForPageLoad
		$I->comment("Exiting Action Group [selectFlatRateShippingMethod] OrderSelectFlatRateShippingActionGroup");
		$I->comment("Step 4: Verify that tax is applied to the order");
		$I->seeElement("//tr[contains(@class,'row-totals')]/td[contains(text(), 'Tax')]/following-sibling::td/span[contains(@class, 'price')]"); // stepKey: seeTax
		$I->comment("Step 5: Select non taxable address as billing address");
		$I->selectOption("//select[@id='order-billing_address_customer_address_id']", "Texas"); // stepKey: selectNonTaxableAddress
		$I->comment("Step 6: Change shipping method to Free");
		$I->comment("Entering Action Group [changeShippingMethod] ChangeShippingMethodActionGroup");
		$I->click("#order-methods span.title"); // stepKey: unfocusChangeShippingMethod
		$I->waitForPageLoad(30); // stepKey: waitForJavascriptToFinishChangeShippingMethod
		$I->click("#order-shipping_method a.action-default"); // stepKey: clickShippingMethods1ChangeShippingMethod
		$I->waitForPageLoad(30); // stepKey: clickShippingMethods1ChangeShippingMethodWaitForPageLoad
		$I->waitForElementVisible("#order-shipping_method a.action-default", 30); // stepKey: waitForChangeShippingMethodChangeShippingMethod
		$I->waitForPageLoad(30); // stepKey: waitForChangeShippingMethodChangeShippingMethodWaitForPageLoad
		$I->click("#order-shipping_method a.action-default"); // stepKey: clickShippingMethods2ChangeShippingMethod
		$I->waitForPageLoad(30); // stepKey: clickShippingMethods2ChangeShippingMethodWaitForPageLoad
		$I->waitForElementVisible("//input[@name='order[shipping_method]']", 30); // stepKey: waitForShippingOptions2ChangeShippingMethod
		$I->selectOption("//input[@name='order[shipping_method]']", "freeshipping_freeshipping"); // stepKey: checkFlatRateChangeShippingMethod
		$I->comment("Exiting Action Group [changeShippingMethod] ChangeShippingMethodActionGroup");
		$I->comment("Step 7: Verify that tax is not applied to the order");
		$I->dontSeeElement("//tr[contains(@class,'row-totals')]/td[contains(text(), 'Tax')]/following-sibling::td/span[contains(@class, 'price')]"); // stepKey: dontSeeTax
	}
}
