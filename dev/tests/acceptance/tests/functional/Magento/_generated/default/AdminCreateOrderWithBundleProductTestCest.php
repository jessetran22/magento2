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
 * @Title("[NO TESTCASEID]: Create Order in Admin and update bundle product configuration")
 * @Description("Add bundle product with bundle option items with default quantity 2 to order in Admin and check price in product grid<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCreateOrderWithBundleProductTest.xml<br>")
 * @group Sales
 */
class AdminCreateOrderWithBundleProductTestCest
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
		$I->comment("Set default flat rate shipping method settings");
		$I->createEntity("setDefaultFlatRateShippingMethod", "hook", "FlatRateShippingMethodDefault", [], []); // stepKey: setDefaultFlatRateShippingMethod
		$I->comment("Create simple customer");
		$I->createEntity("simpleCustomer", "hook", "Simple_US_Customer_CA", [], []); // stepKey: simpleCustomer
		$I->comment("Create simple product 1");
		$I->comment("Create simple product 2");
		$I->comment("Create bundle product with checkbox bundle option");
		$I->createEntity("simple1", "hook", "ApiProductWithDescription", [], []); // stepKey: simple1
		$I->createEntity("simple2", "hook", "ApiProductWithDescription", [], []); // stepKey: simple2
		$I->createEntity("product", "hook", "ApiBundleProduct", [], []); // stepKey: product
		$I->createEntity("checkboxBundleOption", "hook", "CheckboxOption", ["product"], []); // stepKey: checkboxBundleOption
		$I->comment("Link simple product 1 to bundle option with default quantity 2");
		$createBundleLink1Fields['qty'] = "2";
		$createBundleLink1Fields['is_default'] = "1";
		$I->createEntity("createBundleLink1", "hook", "ApiBundleLink", ["product", "checkboxBundleOption", "simple1"], $createBundleLink1Fields); // stepKey: createBundleLink1
		$I->comment("Link simple product 2 to bundle option with default quantity 2");
		$createBundleLink2Fields['qty'] = "2";
		$createBundleLink2Fields['is_default'] = "1";
		$I->createEntity("createBundleLink2", "hook", "ApiBundleLink", ["product", "checkboxBundleOption", "simple2"], $createBundleLink2Fields); // stepKey: createBundleLink2
		$I->comment("Add drop-down bundle option");
		$I->createEntity("dropDownBundleOption", "hook", "DropDownBundleOption", ["product"], []); // stepKey: dropDownBundleOption
		$I->comment("Link simple product 1 to drop-down bundle option with default quantity 2");
		$createBundleLink3Fields['qty'] = "2";
		$createBundleLink3Fields['is_default'] = "1";
		$I->createEntity("createBundleLink3", "hook", "ApiBundleLink", ["product", "dropDownBundleOption", "simple1"], $createBundleLink3Fields); // stepKey: createBundleLink3
		$I->comment("Link simple product 2 to drop-down bundle option with default quantity 2");
		$createBundleLink4Fields['qty'] = "2";
		$I->createEntity("createBundleLink4", "hook", "ApiBundleLink", ["product", "dropDownBundleOption", "simple2"], $createBundleLink4Fields); // stepKey: createBundleLink4
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
		$I->deleteEntity("simple1", "hook"); // stepKey: deleteSimple1
		$I->deleteEntity("simple2", "hook"); // stepKey: deleteSimple2
		$I->deleteEntity("product", "hook"); // stepKey: delete
		$I->deleteEntity("simpleCustomer", "hook"); // stepKey: deleteSimpleCustomer
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
	 * @Stories({"MAGETWO-96488: Wrong price calculation for bundle product on creating order from the admin panel"})
	 * @Features({"Sales"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateOrderWithBundleProductTest(AcceptanceTester $I)
	{
		$I->comment("Create new customer order");
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
		$I->comment("Add bundle product to order and check product price in grid");
		$I->comment("Entering Action Group [addBundleProductToOrder] AddBundleProductToOrderAndCheckPriceInGridActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddBundleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddBundleProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('product', 'sku', 'test')); // stepKey: fillSkuFilterBundleAddBundleProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchBundleAddBundleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchBundleAddBundleProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddBundleProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectBundleProductAddBundleProductToOrder
		$I->waitForElementVisible("#product_composite_configure_input_qty", 30); // stepKey: waitForBundleOptionLoadAddBundleProductToOrder
		$I->wait(2); // stepKey: waitForOptionsToLoadAddBundleProductToOrder
		$I->fillField("#product_composite_configure_input_qty", "1"); // stepKey: fillQuantityAddBundleProductToOrder
		$I->click(".modal-header .page-actions button[data-role='action']"); // stepKey: clickOkAddBundleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickOkAddBundleProductToOrderWaitForPageLoad
		$grabProductPriceFromGridAddBundleProductToOrder = $I->grabTextFrom("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.price"); // stepKey: grabProductPriceFromGridAddBundleProductToOrder
		$I->assertEquals("$738.00", $grabProductPriceFromGridAddBundleProductToOrder, "Bundle product price in grid should be equal $738.00"); // stepKey: assertProductPriceInGridAddBundleProductToOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddBundleProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddBundleProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddBundleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddBundleProductToOrderWaitForPageLoad
		$I->comment("Exiting Action Group [addBundleProductToOrder] AddBundleProductToOrderAndCheckPriceInGridActionGroup");
		$I->comment("Select FlatRate shipping method");
		$I->comment("Entering Action Group [orderSelectFlatRateShippingMethod] OrderSelectFlatRateShippingActionGroup");
		$I->click("#order-methods span.title"); // stepKey: unfocusOrderSelectFlatRateShippingMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForJavascriptToFinishOrderSelectFlatRateShippingMethod
		$I->click("#order-shipping_method a.action-default"); // stepKey: clickShippingMethodsOrderSelectFlatRateShippingMethod
		$I->waitForPageLoad(30); // stepKey: clickShippingMethodsOrderSelectFlatRateShippingMethodWaitForPageLoad
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingOptionsOrderSelectFlatRateShippingMethod
		$I->waitForPageLoad(30); // stepKey: waitForShippingOptionsOrderSelectFlatRateShippingMethodWaitForPageLoad
		$I->selectOption("#s_method_flatrate_flatrate", "flatrate_flatrate"); // stepKey: checkFlatRateOrderSelectFlatRateShippingMethod
		$I->waitForPageLoad(30); // stepKey: checkFlatRateOrderSelectFlatRateShippingMethodWaitForPageLoad
		$I->comment("Exiting Action Group [orderSelectFlatRateShippingMethod] OrderSelectFlatRateShippingActionGroup");
		$I->comment("Entering Action Group [submitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->click("#submit_order_top_button"); // stepKey: clickSubmitOrderSubmitOrder
		$I->waitForPageLoad(30); // stepKey: clickSubmitOrderSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoadSubmitOrder
		$I->comment("Exiting Action Group [submitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->comment("Verify order information");
		$I->comment("Entering Action Group [verifyCreatedOrderInformation] VerifyCreatedOrderInformationActionGroup");
		$I->see("You created the order.", "div.message-success"); // stepKey: seeSuccessMessageVerifyCreatedOrderInformation
		$I->see("Pending", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderPendingStatusVerifyCreatedOrderInformation
		$getOrderIdVerifyCreatedOrderInformation = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: getOrderIdVerifyCreatedOrderInformation
		$I->assertNotEmpty($getOrderIdVerifyCreatedOrderInformation); // stepKey: assertOrderIdIsNotEmptyVerifyCreatedOrderInformation
		$I->comment("Exiting Action Group [verifyCreatedOrderInformation] VerifyCreatedOrderInformationActionGroup");
	}
}
