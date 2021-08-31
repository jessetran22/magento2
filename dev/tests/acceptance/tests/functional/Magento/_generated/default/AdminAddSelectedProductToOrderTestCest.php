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
 * @Title("MC-31589: Add selected products to order in Admin when requested qty more than available")
 * @Description("Trying to add selected products to order in Admin when requested qty more than available<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminAddSelectedProductToOrderTest.xml<br>")
 * @TestCaseId("MC-31589")
 * @group sales
 * @group catalogInventory
 */
class AdminAddSelectedProductToOrderTestCest
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
		$I->createEntity("simpleCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: simpleCustomer
		$I->createEntity("simpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct
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
		$I->deleteEntity("simpleCustomer", "hook"); // stepKey: deleteSimpleCustomer
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Sales"})
	 * @Stories({"Admin create order"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAddSelectedProductToOrderTest(AcceptanceTester $I)
	{
		$I->comment("Initiate create new order");
		$I->comment("Entering Action Group [navigateToNewOrderPageWithExistingCustomer] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageNavigateToNewOrderPageWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadNavigateToNewOrderPageWithExistingCustomer
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleNavigateToNewOrderPageWithExistingCustomer
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderNavigateToNewOrderPageWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderNavigateToNewOrderPageWithExistingCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGridLoadNavigateToNewOrderPageWithExistingCustomer
		$I->comment("Clear grid filters");
		$I->conditionalClick("#sales_order_create_customer_grid [data-action='grid-filter-reset']", "#sales_order_create_customer_grid [data-action='grid-filter-reset']", true); // stepKey: clearExistingCustomerFiltersNavigateToNewOrderPageWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: clearExistingCustomerFiltersNavigateToNewOrderPageWithExistingCustomerWaitForPageLoad
		$I->fillField("#sales_order_create_customer_grid_filter_email", $I->retrieveEntityField('simpleCustomer', 'email', 'test')); // stepKey: filterEmailNavigateToNewOrderPageWithExistingCustomer
		$I->click(".action-secondary[title='Search']"); // stepKey: applyFilterNavigateToNewOrderPageWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForFilteredCustomerGridLoadNavigateToNewOrderPageWithExistingCustomer
		$I->click("tr:nth-of-type(1)[data-role='row']"); // stepKey: clickOnCustomerNavigateToNewOrderPageWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadNavigateToNewOrderPageWithExistingCustomer
		$I->comment("Select store view if appears");
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderPageWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderPageWithExistingCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectNavigateToNewOrderPageWithExistingCustomer
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleNavigateToNewOrderPageWithExistingCustomer
		$I->comment("Exiting Action Group [navigateToNewOrderPageWithExistingCustomer] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->comment("Add to order maximum available quantity - 1");
		$maxQtyMinusOne = $I->executeJS("return 1000 - 1"); // stepKey: maxQtyMinusOne
		$I->comment("Entering Action Group [addProductToOrderWithMaxQtyMinusOne] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddProductToOrderWithMaxQtyMinusOne
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddProductToOrderWithMaxQtyMinusOneWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('simpleProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddProductToOrderWithMaxQtyMinusOne
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddProductToOrderWithMaxQtyMinusOne
		$I->waitForPageLoad(30); // stepKey: clickSearchAddProductToOrderWithMaxQtyMinusOneWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddProductToOrderWithMaxQtyMinusOne
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddProductToOrderWithMaxQtyMinusOne
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", $maxQtyMinusOne); // stepKey: fillProductQtyAddProductToOrderWithMaxQtyMinusOne
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddProductToOrderWithMaxQtyMinusOne
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddProductToOrderWithMaxQtyMinusOneWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddProductToOrderWithMaxQtyMinusOne
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddProductToOrderWithMaxQtyMinusOneWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddProductToOrderWithMaxQtyMinusOne
		$I->comment("Exiting Action Group [addProductToOrderWithMaxQtyMinusOne] AddSimpleProductToOrderActionGroup");
		$I->comment("Check that there is no error or notice");
		$I->comment("Entering Action Group [assertNoticeAbsent] AssertAdminItemOrderedErrorNotVisibleActionGroup");
		$I->dontSee("The requested qty is not available", "//section[@id = 'order-items']//span[text()='" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "']/ancestor::tr/..//div[contains(@class, 'message-notice')]"); // stepKey: assertItemErrorNotVisibleAssertNoticeAbsent
		$I->dontSee("The requested qty is not available", "#order-message div.message-notice"); // stepKey: assertOrderErrorNotVisibleAssertNoticeAbsent
		$I->comment("Exiting Action Group [assertNoticeAbsent] AssertAdminItemOrderedErrorNotVisibleActionGroup");
		$I->comment("Entering Action Group [assertErrorAbsent] AssertAdminItemOrderedErrorNotVisibleActionGroup");
		$I->dontSee("The requested qty is not available", "//section[@id = 'order-items']//span[text()='" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "']/ancestor::tr/..//div[contains(@class, 'message-error')]"); // stepKey: assertItemErrorNotVisibleAssertErrorAbsent
		$I->dontSee("The requested qty is not available", "#order-message div.message-error"); // stepKey: assertOrderErrorNotVisibleAssertErrorAbsent
		$I->comment("Exiting Action Group [assertErrorAbsent] AssertAdminItemOrderedErrorNotVisibleActionGroup");
		$I->comment("Add to order maximum available quantity");
		$I->comment("Entering Action Group [addProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('simpleProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddProductToOrder
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "1"); // stepKey: fillProductQtyAddProductToOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddProductToOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddProductToOrder
		$I->comment("Exiting Action Group [addProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->comment("Check that there is no error or notice");
		$I->comment("Entering Action Group [assertNoticeAbsentAgain] AssertAdminItemOrderedErrorNotVisibleActionGroup");
		$I->dontSee("The requested qty is not available", "//section[@id = 'order-items']//span[text()='" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "']/ancestor::tr/..//div[contains(@class, 'message-notice')]"); // stepKey: assertItemErrorNotVisibleAssertNoticeAbsentAgain
		$I->dontSee("The requested qty is not available", "#order-message div.message-notice"); // stepKey: assertOrderErrorNotVisibleAssertNoticeAbsentAgain
		$I->comment("Exiting Action Group [assertNoticeAbsentAgain] AssertAdminItemOrderedErrorNotVisibleActionGroup");
		$I->comment("Entering Action Group [assertErrorAbsentAgain] AssertAdminItemOrderedErrorNotVisibleActionGroup");
		$I->dontSee("The requested qty is not available", "//section[@id = 'order-items']//span[text()='" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "']/ancestor::tr/..//div[contains(@class, 'message-error')]"); // stepKey: assertItemErrorNotVisibleAssertErrorAbsentAgain
		$I->dontSee("The requested qty is not available", "#order-message div.message-error"); // stepKey: assertOrderErrorNotVisibleAssertErrorAbsentAgain
		$I->comment("Exiting Action Group [assertErrorAbsentAgain] AssertAdminItemOrderedErrorNotVisibleActionGroup");
		$I->comment("Add to order one more quantity");
		$I->comment("Entering Action Group [addProductToOrderAgain] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddProductToOrderAgain
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddProductToOrderAgainWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('simpleProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddProductToOrderAgain
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddProductToOrderAgain
		$I->waitForPageLoad(30); // stepKey: clickSearchAddProductToOrderAgainWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddProductToOrderAgain
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddProductToOrderAgain
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "1"); // stepKey: fillProductQtyAddProductToOrderAgain
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddProductToOrderAgain
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddProductToOrderAgainWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddProductToOrderAgain
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddProductToOrderAgainWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddProductToOrderAgain
		$I->comment("Exiting Action Group [addProductToOrderAgain] AddSimpleProductToOrderActionGroup");
		$I->comment("Check that error remains");
		$I->see("The requested qty is not available"); // stepKey: assertProductErrorRemains
	}
}
