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
 * @Title("[NO TESTCASEID]: Create Order with simple product with custom option.")
 * @Description("Verify, admin able to change file for custom option during order creation.<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCreateOrderWithSimpleProductCustomOptionFileTest.xml<br>")
 * @group Sales
 */
class AdminCreateOrderWithSimpleProductCustomOptionFileTestCest
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
		$I->comment("Create test data.");
		$I->createEntity("category", "hook", "_defaultCategory", [], []); // stepKey: category
		$I->createEntity("simpleProduct", "hook", "SimpleProduct", ["category"], []); // stepKey: simpleProduct
		$I->createEntity("customer", "hook", "Simple_US_Customer_CA", [], []); // stepKey: customer
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
		$I->comment("Clean up created test data.");
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Create Order with simple product with custom option"})
	 * @Features({"Sales"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateOrderWithSimpleProductCustomOptionFileTest(AcceptanceTester $I)
	{
		$I->comment("Add option to product.");
		$I->comment("Entering Action Group [navigateToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('simpleProduct', 'id', 'test')); // stepKey: goToProductNavigateToProductEditPage
		$I->comment("Exiting Action Group [navigateToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [addOption] AddProductCustomOptionFileActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "button[data-index='button_add']", false); // stepKey: openCustomOptionSectionAddOption
		$I->waitForPageLoad(30); // stepKey: openCustomOptionSectionAddOptionWaitForPageLoad
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionAddOption
		$I->waitForPageLoad(30); // stepKey: clickAddOptionAddOptionWaitForPageLoad
		$I->waitForElementVisible("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, '_required')]//input", 30); // stepKey: waitForOptionAddOption
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, '_required')]//input", "OptionFile"); // stepKey: fillTitleAddOption
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__action-multiselect-text')]"); // stepKey: openTypeSelectAddOption
		$I->click("//*[@data-index='custom_options']//label[text()='File'][ancestor::*[contains(@class, '_active')]]"); // stepKey: selectTypeFileAddOption
		$I->waitForElementVisible("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'OptionFile')]/ancestor::tr//*[@data-index='price']//input", 30); // stepKey: waitForElementsAddOption
		$I->fillField("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'OptionFile')]/ancestor::tr//*[@data-index='price']//input", "9.99"); // stepKey: fillPriceAddOption
		$I->selectOption("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'OptionFile')]/ancestor::tr//*[@data-index='price_type']//select", "fixed"); // stepKey: selectPriceTypeAddOption
		$I->fillField("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'OptionFile')]/ancestor::tr//*[@data-index='file_extension']//input", "png, jpg, gif"); // stepKey: fillCompatibleExtensionsAddOption
		$I->comment("Exiting Action Group [addOption] AddProductCustomOptionFileActionGroup");
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$I->comment("Create order.");
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
		$I->fillField("#sales_order_create_customer_grid_filter_email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: filterEmailNavigateToNewOrderWithExistingCustomer
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
		$I->comment("Entering Action Group [addSimpleProductToOrder] AdminAddSimpleProductWithCustomOptionFileToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddSimpleProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('simpleProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddSimpleProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddSimpleProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddSimpleProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddSimpleProductToOrder
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxLoadAddSimpleProductToOrder
		$I->fillField("//input[@id='product_composite_configure_input_qty']", $I->retrieveEntityField('simpleProduct', 'quantity', 'test')); // stepKey: fillProductQtyAddSimpleProductToOrder
		$I->attachFile("//input[@type='file'][contains(@class, 'product-custom-option')]", "magento-again.jpg"); // stepKey: attachImageForOptionalAddSimpleProductToOrder
		$I->click("//button[contains(@class, 'action-primary')][@data-role='action']"); // stepKey: clickButtonOKAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickButtonOKAddSimpleProductToOrderWaitForPageLoad
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddSimpleProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddSimpleProductToOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddSimpleProductToOrder
		$I->comment("Exiting Action Group [addSimpleProductToOrder] AdminAddSimpleProductWithCustomOptionFileToOrderActionGroup");
		$I->comment("Verify, admin able to change file for custom option.");
		$I->comment("Entering Action Group [changeFile] AdminChangeCustomerOptionFileActionGroup");
		$I->click(".product-configure-block button.action-default.scalable"); // stepKey: clickConfigureChangeFile
		$I->waitForPageLoad(30); // stepKey: clickConfigureChangeFileWaitForPageLoad
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxLoadChangeFile
		$I->click("//div[contains(@class, 'entry-edit')]//a[contains(text(),'Change')]"); // stepKey: clickLinkChangeChangeFile
		$I->waitForPageLoad(30); // stepKey: waitForChangeLoadChangeFile
		$I->attachFile("//input[@type='file'][contains(@class, 'product-custom-option')]", "magento-again.jpg"); // stepKey: changeAttachImageChangeFile
		$I->click("//button[contains(@class, 'action-primary')][@data-role='action']"); // stepKey: clickButtonOKChangeFile
		$I->waitForPageLoad(30); // stepKey: clickButtonOKChangeFileWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomOptionAppliedChangeFile
		$I->comment("Exiting Action Group [changeFile] AdminChangeCustomerOptionFileActionGroup");
	}
}
