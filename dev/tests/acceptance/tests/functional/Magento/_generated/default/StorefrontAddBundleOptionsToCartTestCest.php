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
 * @Title("MAGETWO-95933: Checking adding of bundle options to the cart")
 * @Description("Verifying adding of bundle options to the cart<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/StorefrontAddBundleOptionsToCartTest.xml<br>")
 * @TestCaseId("MAGETWO-95933")
 * @group Bundle
 */
class StorefrontAddBundleOptionsToCartTestCest
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
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct1
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct2
		$I->createEntity("simpleProduct3", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct3
		$I->createEntity("simpleProduct4", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct4
		$I->createEntity("simpleProduct5", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct5
		$I->createEntity("simpleProduct6", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct6
		$I->createEntity("simpleProduct7", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct7
		$I->createEntity("simpleProduct8", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct8
		$I->createEntity("simpleProduct9", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct9
		$I->createEntity("simpleProduct10", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct10
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->deleteEntity("simpleProduct3", "hook"); // stepKey: deleteSimpleProduct3
		$I->deleteEntity("simpleProduct4", "hook"); // stepKey: deleteSimpleProduct4
		$I->deleteEntity("simpleProduct5", "hook"); // stepKey: deleteSimpleProduct5
		$I->deleteEntity("simpleProduct6", "hook"); // stepKey: deleteSimpleProduct6
		$I->deleteEntity("simpleProduct7", "hook"); // stepKey: deleteSimpleProduct7
		$I->deleteEntity("simpleProduct8", "hook"); // stepKey: deleteSimpleProduct8
		$I->deleteEntity("simpleProduct9", "hook"); // stepKey: deleteSimpleProduct9
		$I->deleteEntity("simpleProduct10", "hook"); // stepKey: deleteSimpleProduct10
		$I->comment("delete created bundle product");
		$I->comment("Entering Action Group [deleteProduct1] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct1
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteProduct1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteProduct1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct1
		$I->fillField("input.admin__control-text[name='sku']", "bundleproduct" . msq("BundleProduct")); // stepKey: fillProductSkuFilterDeleteProduct1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProduct1WaitForPageLoad
		$I->see("bundleproduct" . msq("BundleProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct1
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct1
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct1
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct1
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProduct1WaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct1
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProduct1WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteProduct1
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteProduct1WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct1
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProduct1WaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteProduct1
		$I->comment("Exiting Action Group [deleteProduct1] DeleteProductBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersWaitForPageLoad
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
	 * @Features({"Bundle"})
	 * @Stories({"MAGETWO-95813: Only two bundle options are added to the cart"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAddBundleOptionsToCartTest(AcceptanceTester $I)
	{
		$I->comment("Start creating a bundle product");
		$I->comment("Entering Action Group [goToProductList] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageGoToProductList
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadGoToProductList
		$I->comment("Exiting Action Group [goToProductList] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [goToCreateProduct] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleGoToCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleGoToCreateProductWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-bundle']", 30); // stepKey: waitForAddProductDropdownGoToCreateProduct
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-bundle']"); // stepKey: clickAddProductTypeGoToCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadGoToCreateProduct
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/bundle/"); // stepKey: seeNewProductUrlGoToCreateProduct
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleGoToCreateProduct
		$I->comment("Exiting Action Group [goToCreateProduct] GoToCreateProductPageActionGroup");
		$I->comment("Entering Action Group [fillNameAndSku] FillProductNameAndSkuInProductFormActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductNameFillNameAndSku
		$I->fillField(".admin__field[data-index=sku] input", "bundleproduct" . msq("BundleProduct")); // stepKey: fillProductSkuFillNameAndSku
		$I->comment("Exiting Action Group [fillNameAndSku] FillProductNameAndSkuInProductFormActionGroup");
		$I->comment("Add Option One, a \"Checkbox\" type option, with tree products");
		$I->comment("Entering Action Group [addBundleOptionWithTreeProducts] AddBundleOptionWithThreeProductsActionGroup");
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenSectionBundleItemsAddBundleOptionWithTreeProducts
		$I->scrollTo("//span[text()='Bundle Items']"); // stepKey: scrollUpABitAddBundleOptionWithTreeProducts
		$I->click("button[data-index='add_button']"); // stepKey: clickAddOptionAddBundleOptionWithTreeProducts
		$I->waitForElementVisible("[name='bundle_options[bundle_options][0][title]']", 30); // stepKey: waitForOptionsAddBundleOptionWithTreeProducts
		$I->fillField("[name='bundle_options[bundle_options][0][title]']", "Option One"); // stepKey: fillTitleAddBundleOptionWithTreeProducts
		$I->selectOption("[name='bundle_options[bundle_options][0][type]']", "checkbox"); // stepKey: selectTypeAddBundleOptionWithTreeProducts
		$I->waitForElementVisible("//tr[1]//button[@data-index='modal_set']", 30); // stepKey: waitForAddBtnAddBundleOptionWithTreeProducts
		$I->waitForPageLoad(30); // stepKey: waitForAddBtnAddBundleOptionWithTreeProductsWaitForPageLoad
		$I->click("//tr[1]//button[@data-index='modal_set']"); // stepKey: clickAddAddBundleOptionWithTreeProducts
		$I->waitForPageLoad(30); // stepKey: clickAddAddBundleOptionWithTreeProductsWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters1AddBundleOptionWithTreeProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFilters1AddBundleOptionWithTreeProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters1AddBundleOptionWithTreeProducts
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilter1AddBundleOptionWithTreeProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters1AddBundleOptionWithTreeProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters1AddBundleOptionWithTreeProductsWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad1AddBundleOptionWithTreeProducts
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct1AddBundleOptionWithTreeProducts
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters2AddBundleOptionWithTreeProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFilters2AddBundleOptionWithTreeProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters2AddBundleOptionWithTreeProducts
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct2', 'sku', 'test')); // stepKey: fillProductSkuFilter2AddBundleOptionWithTreeProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters2AddBundleOptionWithTreeProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters2AddBundleOptionWithTreeProductsWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad2AddBundleOptionWithTreeProducts
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct2AddBundleOptionWithTreeProducts
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters3AddBundleOptionWithTreeProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFilters3AddBundleOptionWithTreeProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters3AddBundleOptionWithTreeProducts
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct3', 'sku', 'test')); // stepKey: fillProductSkuFilter3AddBundleOptionWithTreeProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters3AddBundleOptionWithTreeProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters3AddBundleOptionWithTreeProductsWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad3AddBundleOptionWithTreeProducts
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct3AddBundleOptionWithTreeProducts
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddButton1AddBundleOptionWithTreeProducts
		$I->waitForPageLoad(30); // stepKey: clickAddButton1AddBundleOptionWithTreeProductsWaitForPageLoad
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][0][selection_qty]']", "1"); // stepKey: fillQuantity1AddBundleOptionWithTreeProducts
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][1][selection_qty]']", "1"); // stepKey: fillQuantity2AddBundleOptionWithTreeProducts
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][2][selection_qty]']", "1"); // stepKey: fillQuantity3AddBundleOptionWithTreeProducts
		$I->comment("Exiting Action Group [addBundleOptionWithTreeProducts] AddBundleOptionWithThreeProductsActionGroup");
		$I->comment("Add Option Two, a \"Radio Buttons\" type option, with one product");
		$I->comment("Entering Action Group [addBundleOptionWithOneProduct] AddBundleOptionWithOneProductActionGroup");
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenSectionBundleItemsAddBundleOptionWithOneProduct
		$I->scrollTo("//span[text()='Bundle Items']"); // stepKey: scrollUpABitAddBundleOptionWithOneProduct
		$I->click("button[data-index='add_button']"); // stepKey: clickAddOptionAddBundleOptionWithOneProduct
		$I->waitForElementVisible("[name='bundle_options[bundle_options][1][title]']", 30); // stepKey: waitForOptionsAddBundleOptionWithOneProduct
		$I->fillField("[name='bundle_options[bundle_options][1][title]']", "Option Two"); // stepKey: fillTitleAddBundleOptionWithOneProduct
		$I->selectOption("[name='bundle_options[bundle_options][1][type]']", "radio"); // stepKey: selectTypeAddBundleOptionWithOneProduct
		$I->waitForElementVisible("//tr[2]//button[@data-index='modal_set']", 30); // stepKey: waitForAddBtnAddBundleOptionWithOneProduct
		$I->waitForPageLoad(30); // stepKey: waitForAddBtnAddBundleOptionWithOneProductWaitForPageLoad
		$I->click("//tr[2]//button[@data-index='modal_set']"); // stepKey: clickAddAddBundleOptionWithOneProduct
		$I->waitForPageLoad(30); // stepKey: clickAddAddBundleOptionWithOneProductWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters1AddBundleOptionWithOneProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFilters1AddBundleOptionWithOneProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters1AddBundleOptionWithOneProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct4', 'sku', 'test')); // stepKey: fillProductSkuFilter1AddBundleOptionWithOneProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters1AddBundleOptionWithOneProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters1AddBundleOptionWithOneProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad1AddBundleOptionWithOneProduct
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct1AddBundleOptionWithOneProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters2AddBundleOptionWithOneProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFilters2AddBundleOptionWithOneProductWaitForPageLoad
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddButton1AddBundleOptionWithOneProduct
		$I->waitForPageLoad(30); // stepKey: clickAddButton1AddBundleOptionWithOneProductWaitForPageLoad
		$I->fillField("[name='bundle_options[bundle_options][1][bundle_selections][0][selection_qty]']", "1"); // stepKey: fillQuantityAddBundleOptionWithOneProduct
		$I->comment("Exiting Action Group [addBundleOptionWithOneProduct] AddBundleOptionWithOneProductActionGroup");
		$I->comment("Add Option Tree, a \"Checkbox\" type option, with six products");
		$I->comment("Entering Action Group [addBundleOptionWithSixProducts] AddBundleOptionWithSixProductsActionGroup");
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenSectionBundleItemsAddBundleOptionWithSixProducts
		$I->scrollTo("//span[text()='Bundle Items']"); // stepKey: scrollUpABitAddBundleOptionWithSixProducts
		$I->click("button[data-index='add_button']"); // stepKey: clickAddOptionAddBundleOptionWithSixProducts
		$I->waitForElementVisible("[name='bundle_options[bundle_options][2][title]']", 30); // stepKey: waitForOptionsAddBundleOptionWithSixProducts
		$I->fillField("[name='bundle_options[bundle_options][2][title]']", "Option Tree"); // stepKey: fillTitleAddBundleOptionWithSixProducts
		$I->selectOption("[name='bundle_options[bundle_options][2][type]']", "checkbox"); // stepKey: selectTypeAddBundleOptionWithSixProducts
		$I->waitForElementVisible("//tr[3]//button[@data-index='modal_set']", 30); // stepKey: waitForAddBtnAddBundleOptionWithSixProducts
		$I->waitForPageLoad(30); // stepKey: waitForAddBtnAddBundleOptionWithSixProductsWaitForPageLoad
		$I->click("//tr[3]//button[@data-index='modal_set']"); // stepKey: clickAddAddBundleOptionWithSixProducts
		$I->waitForPageLoad(30); // stepKey: clickAddAddBundleOptionWithSixProductsWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters1AddBundleOptionWithSixProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFilters1AddBundleOptionWithSixProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters1AddBundleOptionWithSixProducts
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct5', 'sku', 'test')); // stepKey: fillProductSkuFilter1AddBundleOptionWithSixProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters1AddBundleOptionWithSixProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters1AddBundleOptionWithSixProductsWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad1AddBundleOptionWithSixProducts
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct1AddBundleOptionWithSixProducts
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters2AddBundleOptionWithSixProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFilters2AddBundleOptionWithSixProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters2AddBundleOptionWithSixProducts
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct6', 'sku', 'test')); // stepKey: fillProductSkuFilter2AddBundleOptionWithSixProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters2AddBundleOptionWithSixProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters2AddBundleOptionWithSixProductsWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad2AddBundleOptionWithSixProducts
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct2AddBundleOptionWithSixProducts
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters3AddBundleOptionWithSixProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFilters3AddBundleOptionWithSixProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters3AddBundleOptionWithSixProducts
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct7', 'sku', 'test')); // stepKey: fillProductSkuFilter3AddBundleOptionWithSixProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters3AddBundleOptionWithSixProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters3AddBundleOptionWithSixProductsWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad3AddBundleOptionWithSixProducts
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct3AddBundleOptionWithSixProducts
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters4AddBundleOptionWithSixProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFilters4AddBundleOptionWithSixProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters4AddBundleOptionWithSixProducts
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct8', 'sku', 'test')); // stepKey: fillProductSkuFilter4AddBundleOptionWithSixProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters4AddBundleOptionWithSixProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters4AddBundleOptionWithSixProductsWaitForPageLoad
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct4AddBundleOptionWithSixProducts
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters5AddBundleOptionWithSixProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFilters5AddBundleOptionWithSixProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters5AddBundleOptionWithSixProducts
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct9', 'sku', 'test')); // stepKey: fillProductSkuFilter5AddBundleOptionWithSixProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters5AddBundleOptionWithSixProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters5AddBundleOptionWithSixProductsWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad5AddBundleOptionWithSixProducts
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct5AddBundleOptionWithSixProducts
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters6AddBundleOptionWithSixProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFilters6AddBundleOptionWithSixProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters6AddBundleOptionWithSixProducts
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct10', 'sku', 'test')); // stepKey: fillProductSkuFilter6AddBundleOptionWithSixProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters6AddBundleOptionWithSixProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters6AddBundleOptionWithSixProductsWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad6AddBundleOptionWithSixProducts
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct6AddBundleOptionWithSixProducts
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad4AddBundleOptionWithSixProducts
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddButton1AddBundleOptionWithSixProducts
		$I->waitForPageLoad(30); // stepKey: clickAddButton1AddBundleOptionWithSixProductsWaitForPageLoad
		$I->fillField("[name='bundle_options[bundle_options][2][bundle_selections][0][selection_qty]']", "2"); // stepKey: fillQuantity1AddBundleOptionWithSixProducts
		$I->fillField("[name='bundle_options[bundle_options][2][bundle_selections][1][selection_qty]']", "2"); // stepKey: fillQuantity2AddBundleOptionWithSixProducts
		$I->fillField("[name='bundle_options[bundle_options][2][bundle_selections][2][selection_qty]']", "2"); // stepKey: fillQuantity3AddBundleOptionWithSixProducts
		$I->fillField("[name='bundle_options[bundle_options][2][bundle_selections][3][selection_qty]']", "2"); // stepKey: fillQuantity4AddBundleOptionWithSixProducts
		$I->fillField("[name='bundle_options[bundle_options][2][bundle_selections][4][selection_qty]']", "2"); // stepKey: fillQuantity5AddBundleOptionWithSixProducts
		$I->fillField("[name='bundle_options[bundle_options][2][bundle_selections][5][selection_qty]']", "2"); // stepKey: fillQuantity6AddBundleOptionWithSixProducts
		$I->comment("Exiting Action Group [addBundleOptionWithSixProducts] AddBundleOptionWithSixProductsActionGroup");
		$I->comment("Save product");
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
		$I->comment("Go to Storefront and open Bundle Product page");
		$I->amOnPage("bundleproduct" . msq("BundleProduct") . ".html"); // stepKey: goToStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefront
		$I->comment("Click \"Customize and Add to Cart\" button");
		$I->click("#bundle-slide"); // stepKey: clickCustomize
		$I->waitForPageLoad(30); // stepKey: clickCustomizeWaitForPageLoad
		$I->comment("Assert Bundle Product Price");
		$grabProductsPrice = $I->grabTextFrom("//*[@class='bundle-info']//*[contains(@id,'product-price')]/span"); // stepKey: grabProductsPrice
		$I->assertEquals("$123.00", $grabProductsPrice, "ExpectedPrice"); // stepKey: assertBundleProductPrice
		$I->comment("Chose all products from 1st & 3rd options");
		$I->click("//*[@id='customizeTitle']/following-sibling::div[1]//div[1][@class='field choice']/input"); // stepKey: selectProduct1
		$I->click("//*[@id='customizeTitle']/following-sibling::div[1]//div[2][@class='field choice']/input"); // stepKey: selectProduct2
		$I->click("//*[@id='customizeTitle']/following-sibling::div[1]//div[3][@class='field choice']/input"); // stepKey: selectProduct3
		$I->click("//*[@id='customizeTitle']/following-sibling::div[3]//div[1][@class='field choice']/input"); // stepKey: selectProduct5
		$I->click("//*[@id='customizeTitle']/following-sibling::div[3]//div[2][@class='field choice']/input"); // stepKey: selectProduct6
		$I->click("//*[@id='customizeTitle']/following-sibling::div[3]//div[3][@class='field choice']/input"); // stepKey: selectProduct7
		$I->click("//*[@id='customizeTitle']/following-sibling::div[3]//div[4][@class='field choice']/input"); // stepKey: selectProduct8
		$I->click("//*[@id='customizeTitle']/following-sibling::div[3]//div[5][@class='field choice']/input"); // stepKey: selectProduct9
		$I->click("//*[@id='customizeTitle']/following-sibling::div[3]//div[6][@class='field choice']/input"); // stepKey: selectProduct10
		$I->comment("Click \"Add to Cart\" button");
		$I->click("#product-addtocart-button"); // stepKey: clickAddBundleProductToCart
		$I->waitForPageLoad(30); // stepKey: clickAddBundleProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddBundleProductPageLoad
		$I->comment("Click \"mini cart\" icon");
		$I->comment("Entering Action Group [openCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageOpenCart
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartOpenCart
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartOpenCartWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkOpenCart
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkOpenCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartOpenCart
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartOpenCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartOpenCart
		$I->waitForPageLoad(30); // stepKey: clickCartOpenCartWaitForPageLoad
		$I->comment("Exiting Action Group [openCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForDetailsOpen
		$I->comment("Entering Action Group [cartAssert] StorefrontCheckCartActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: assertUrlCartAssert
		$I->waitForPageLoad(30); // stepKey: waitForCartPageCartAssert
		$I->conditionalClick("#block-shipping-heading", "#co-shipping-method-form", false); // stepKey: openEstimateShippingSectionCartAssert
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingSectionCartAssert
		$I->waitForPageLoad(30); // stepKey: waitForShippingSectionCartAssertWaitForPageLoad
		$I->checkOption("#s_method_flatrate_flatrate"); // stepKey: selectShippingMethodCartAssert
		$I->waitForPageLoad(30); // stepKey: selectShippingMethodCartAssertWaitForPageLoad
		$I->scrollTo("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: scrollToSummaryCartAssert
		$I->see("1,968.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalCartAssert
		$I->see("(Flat Rate - Fixed)", "//*[@id='cart-totals']//tr[@class='totals shipping excl']//th//span[@class='value']"); // stepKey: assertShippingMethodCartAssert
		$I->waitForText("5.00", 45, "//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']"); // stepKey: assertShippingCartAssert
		$I->see("1,973.00", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalCartAssert
		$I->comment("Exiting Action Group [cartAssert] StorefrontCheckCartActionGroup");
		$I->comment("Check all products and Cart Subtotal");
	}
}
