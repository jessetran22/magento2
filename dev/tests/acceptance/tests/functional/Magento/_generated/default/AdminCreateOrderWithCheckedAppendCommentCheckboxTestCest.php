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
 * @Title("[NO TESTCASEID]: Check if checked Append Comment checkbox isn't reset after shippinhg method selecting")
 * @Description("Check if checked Append Comment checkbox isn't reset after shippinhg method selectiong<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCreateOrderWithCheckedAppendCommentCheckboxTest.xml<br>")
 * @group sales
 */
class AdminCreateOrderWithCheckedAppendCommentCheckboxTestCest
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
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "defaultSimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$enableCheckMoneyOrder = $I->magentoCLI("config:set payment/checkmo/active 1", 60); // stepKey: enableCheckMoneyOrder
		$I->comment($enableCheckMoneyOrder);
		$I->createEntity("enableFlatRate", "hook", "FlatRateShippingMethodConfig", [], []); // stepKey: enableFlatRate
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"Create Order With Checked Append Comment checkbox"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateOrderWithCheckedAppendCommentCheckboxTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToNewOrderPage] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadNavigateToNewOrderPage
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleNavigateToNewOrderPage
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderNavigateToNewOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGridLoadNavigateToNewOrderPage
		$I->comment("Clear grid filters");
		$I->conditionalClick("#sales_order_create_customer_grid [data-action='grid-filter-reset']", "#sales_order_create_customer_grid [data-action='grid-filter-reset']", true); // stepKey: clearExistingCustomerFiltersNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: clearExistingCustomerFiltersNavigateToNewOrderPageWaitForPageLoad
		$I->fillField("#sales_order_create_customer_grid_filter_email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailNavigateToNewOrderPage
		$I->click(".action-secondary[title='Search']"); // stepKey: applyFilterNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForFilteredCustomerGridLoadNavigateToNewOrderPage
		$I->click("tr:nth-of-type(1)[data-role='row']"); // stepKey: clickOnCustomerNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadNavigateToNewOrderPage
		$I->comment("Select store view if appears");
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectNavigateToNewOrderPage
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleNavigateToNewOrderPage
		$I->comment("Exiting Action Group [navigateToNewOrderPage] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->comment("Entering Action Group [addProduct] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddProductWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddProduct
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddProduct
		$I->waitForPageLoad(30); // stepKey: clickSearchAddProductWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddProduct
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddProduct
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "1"); // stepKey: fillProductQtyAddProduct
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddProduct
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddProductWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddProduct
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddProductWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddProduct
		$I->comment("Exiting Action Group [addProduct] AddSimpleProductToOrderActionGroup");
		$I->comment("Entering Action Group [provideComment] AdminAddCommentOnCreateOrderPageActionGroup");
		$I->fillField("textarea#order-comment", "Test Order Comment"); // stepKey: provideCommentProvideComment
		$I->comment("Exiting Action Group [provideComment] AdminAddCommentOnCreateOrderPageActionGroup");
		$I->seeCheckboxIsChecked("input#notify_customer"); // stepKey: checkAppendCommentsCheckboxIsCheckedAfterCommentProvided
		$I->scrollTo("#order-methods span.title"); // stepKey: scrollUp
		$I->comment("Entering Action Group [selectFlatRate] AdminSelectFlatRateShippingMethodOnCreateOrderPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoadSelectFlatRate
		$I->conditionalClick("//span[text()='Get shipping methods and rates']", "//span[text()='Get shipping methods and rates']", true); // stepKey: openShippingMethodIfCollapsedSelectFlatRate
		$I->waitForPageLoad(60); // stepKey: openShippingMethodIfCollapsedSelectFlatRateWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodsSelectFlatRate
		$I->click("//label[contains(text(), 'Fixed')]"); // stepKey: chooseShippingMethodSelectFlatRate
		$I->waitForPageLoad(60); // stepKey: chooseShippingMethodSelectFlatRateWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSelectFlatRate
		$I->comment("Exiting Action Group [selectFlatRate] AdminSelectFlatRateShippingMethodOnCreateOrderPageActionGroup");
		$I->comment("Entering Action Group [selectPaymentMethod] SelectCheckMoneyPaymentMethodActionGroup");
		$I->waitForElementVisible("#order-billing_method", 30); // stepKey: waitForPaymentOptionsSelectPaymentMethod
		$I->conditionalClick("#p_method_checkmo", "#p_method_checkmo", true); // stepKey: checkCheckMoneyOptionSelectPaymentMethod
		$I->waitForPageLoad(30); // stepKey: checkCheckMoneyOptionSelectPaymentMethodWaitForPageLoad
		$I->comment("Exiting Action Group [selectPaymentMethod] SelectCheckMoneyPaymentMethodActionGroup");
		$I->seeCheckboxIsChecked("input#notify_customer"); // stepKey: checkAppendCommentsCheckboxIsCheckedAfterShippingSelected
		$I->comment("Entering Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$I->scrollTo("#submit_order_top_button"); // stepKey: scrollToSubmitButtonSubmitOrder
		$I->waitForPageLoad(60); // stepKey: scrollToSubmitButtonSubmitOrderWaitForPageLoad
		$I->click("#submit_order_top_button"); // stepKey: submitOrderSubmitOrder
		$I->waitForPageLoad(60); // stepKey: submitOrderSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSubmitOrder
		$I->see("You created the order."); // stepKey: seeSuccessMessageForOrderSubmitOrder
		$I->comment("Exiting Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$I->comment("Entering Action Group [assertCustomerIsNotified] AdminCheckIfCustomerIsNotifiedOfOrderCommentActionGroup");
		$grabStatusOfOrderNoteAssertCustomerIsNotified = $I->grabTextFrom("//div[@class='note-list-comment' and contains(text(),'Test Order Comment')]//preceding-sibling::span[@class='note-list-customer']/span"); // stepKey: grabStatusOfOrderNoteAssertCustomerIsNotified
		$I->assertEquals("Notified", $grabStatusOfOrderNoteAssertCustomerIsNotified, "Assert Order Note status is correct"); // stepKey: assertCustomerIsNotifiedAssertCustomerIsNotified
		$I->comment("Exiting Action Group [assertCustomerIsNotified] AdminCheckIfCustomerIsNotifiedOfOrderCommentActionGroup");
	}
}
