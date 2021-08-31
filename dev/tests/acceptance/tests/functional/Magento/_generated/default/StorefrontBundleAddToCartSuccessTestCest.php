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
 * @Title("MC-232: Customer should be able to add the bundle product to the cart")
 * @Description("Customer should be able to add the bundle product to the cart<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/StorefrontBundleAddToCartSuccessTest.xml<br>")
 * @TestCaseId("MC-232")
 * @group Bundle
 */
class StorefrontBundleAddToCartSuccessTestCest
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
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
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
	 * @Stories({"Bundle product details page"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontBundleAddToCartSuccessTest(AcceptanceTester $I)
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
		$I->comment("Add Option One, a \"Drop-down\" type option");
		$I->comment("Entering Action Group [addBundleOptionWithTwoProducts1] AddBundleOptionWithTwoProductsActionGroup");
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenSectionBundleItemsAddBundleOptionWithTwoProducts1
		$I->scrollTo("//span[text()='Bundle Items']"); // stepKey: scrollUpABitAddBundleOptionWithTwoProducts1
		$I->click("button[data-index='add_button']"); // stepKey: clickAddOptionAddBundleOptionWithTwoProducts1
		$I->waitForElementVisible("[name='bundle_options[bundle_options][0][title]']", 30); // stepKey: waitForOptionsAddBundleOptionWithTwoProducts1
		$I->fillField("[name='bundle_options[bundle_options][0][title]']", "Option One"); // stepKey: fillTitleAddBundleOptionWithTwoProducts1
		$I->selectOption("[name='bundle_options[bundle_options][0][type]']", "select"); // stepKey: selectTypeAddBundleOptionWithTwoProducts1
		$I->waitForElementVisible("//tr[1]//button[@data-index='modal_set']", 30); // stepKey: waitForAddBtnAddBundleOptionWithTwoProducts1
		$I->waitForPageLoad(30); // stepKey: waitForAddBtnAddBundleOptionWithTwoProducts1WaitForPageLoad
		$I->click("//tr[1]//button[@data-index='modal_set']"); // stepKey: clickAddAddBundleOptionWithTwoProducts1
		$I->waitForPageLoad(30); // stepKey: clickAddAddBundleOptionWithTwoProducts1WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters1AddBundleOptionWithTwoProducts1
		$I->waitForPageLoad(30); // stepKey: clickClearFilters1AddBundleOptionWithTwoProducts1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters1AddBundleOptionWithTwoProducts1
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilter1AddBundleOptionWithTwoProducts1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters1AddBundleOptionWithTwoProducts1
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters1AddBundleOptionWithTwoProducts1WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad1AddBundleOptionWithTwoProducts1
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct1AddBundleOptionWithTwoProducts1
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters2AddBundleOptionWithTwoProducts1
		$I->waitForPageLoad(30); // stepKey: clickClearFilters2AddBundleOptionWithTwoProducts1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters2AddBundleOptionWithTwoProducts1
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct2', 'sku', 'test')); // stepKey: fillProductSkuFilter2AddBundleOptionWithTwoProducts1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters2AddBundleOptionWithTwoProducts1
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters2AddBundleOptionWithTwoProducts1WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad2AddBundleOptionWithTwoProducts1
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct2AddBundleOptionWithTwoProducts1
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddButton1AddBundleOptionWithTwoProducts1
		$I->waitForPageLoad(30); // stepKey: clickAddButton1AddBundleOptionWithTwoProducts1WaitForPageLoad
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][0][selection_qty]']", "50"); // stepKey: fillQuantity1AddBundleOptionWithTwoProducts1
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][1][selection_qty]']", "50"); // stepKey: fillQuantity2AddBundleOptionWithTwoProducts1
		$I->comment("Exiting Action Group [addBundleOptionWithTwoProducts1] AddBundleOptionWithTwoProductsActionGroup");
		$I->comment("Add Option Two, a \"Radio Buttons\" type option");
		$I->comment("Entering Action Group [addBundleOptionWithTwoProducts2] AddBundleOptionWithTwoProductsActionGroup");
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenSectionBundleItemsAddBundleOptionWithTwoProducts2
		$I->scrollTo("//span[text()='Bundle Items']"); // stepKey: scrollUpABitAddBundleOptionWithTwoProducts2
		$I->click("button[data-index='add_button']"); // stepKey: clickAddOptionAddBundleOptionWithTwoProducts2
		$I->waitForElementVisible("[name='bundle_options[bundle_options][1][title]']", 30); // stepKey: waitForOptionsAddBundleOptionWithTwoProducts2
		$I->fillField("[name='bundle_options[bundle_options][1][title]']", "Option Two"); // stepKey: fillTitleAddBundleOptionWithTwoProducts2
		$I->selectOption("[name='bundle_options[bundle_options][1][type]']", "radio"); // stepKey: selectTypeAddBundleOptionWithTwoProducts2
		$I->waitForElementVisible("//tr[2]//button[@data-index='modal_set']", 30); // stepKey: waitForAddBtnAddBundleOptionWithTwoProducts2
		$I->waitForPageLoad(30); // stepKey: waitForAddBtnAddBundleOptionWithTwoProducts2WaitForPageLoad
		$I->click("//tr[2]//button[@data-index='modal_set']"); // stepKey: clickAddAddBundleOptionWithTwoProducts2
		$I->waitForPageLoad(30); // stepKey: clickAddAddBundleOptionWithTwoProducts2WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters1AddBundleOptionWithTwoProducts2
		$I->waitForPageLoad(30); // stepKey: clickClearFilters1AddBundleOptionWithTwoProducts2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters1AddBundleOptionWithTwoProducts2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilter1AddBundleOptionWithTwoProducts2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters1AddBundleOptionWithTwoProducts2
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters1AddBundleOptionWithTwoProducts2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad1AddBundleOptionWithTwoProducts2
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct1AddBundleOptionWithTwoProducts2
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters2AddBundleOptionWithTwoProducts2
		$I->waitForPageLoad(30); // stepKey: clickClearFilters2AddBundleOptionWithTwoProducts2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters2AddBundleOptionWithTwoProducts2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct2', 'sku', 'test')); // stepKey: fillProductSkuFilter2AddBundleOptionWithTwoProducts2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters2AddBundleOptionWithTwoProducts2
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters2AddBundleOptionWithTwoProducts2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad2AddBundleOptionWithTwoProducts2
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct2AddBundleOptionWithTwoProducts2
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddButton1AddBundleOptionWithTwoProducts2
		$I->waitForPageLoad(30); // stepKey: clickAddButton1AddBundleOptionWithTwoProducts2WaitForPageLoad
		$I->fillField("[name='bundle_options[bundle_options][1][bundle_selections][0][selection_qty]']", "50"); // stepKey: fillQuantity1AddBundleOptionWithTwoProducts2
		$I->fillField("[name='bundle_options[bundle_options][1][bundle_selections][1][selection_qty]']", "50"); // stepKey: fillQuantity2AddBundleOptionWithTwoProducts2
		$I->comment("Exiting Action Group [addBundleOptionWithTwoProducts2] AddBundleOptionWithTwoProductsActionGroup");
		$I->comment("Add Option Three, a \"Checkbox\" type option");
		$I->comment("Entering Action Group [addBundleOptionWithTwoProducts3] AddBundleOptionWithTwoProductsActionGroup");
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenSectionBundleItemsAddBundleOptionWithTwoProducts3
		$I->scrollTo("//span[text()='Bundle Items']"); // stepKey: scrollUpABitAddBundleOptionWithTwoProducts3
		$I->click("button[data-index='add_button']"); // stepKey: clickAddOptionAddBundleOptionWithTwoProducts3
		$I->waitForElementVisible("[name='bundle_options[bundle_options][2][title]']", 30); // stepKey: waitForOptionsAddBundleOptionWithTwoProducts3
		$I->fillField("[name='bundle_options[bundle_options][2][title]']", "Option Three"); // stepKey: fillTitleAddBundleOptionWithTwoProducts3
		$I->selectOption("[name='bundle_options[bundle_options][2][type]']", "checkbox"); // stepKey: selectTypeAddBundleOptionWithTwoProducts3
		$I->waitForElementVisible("//tr[3]//button[@data-index='modal_set']", 30); // stepKey: waitForAddBtnAddBundleOptionWithTwoProducts3
		$I->waitForPageLoad(30); // stepKey: waitForAddBtnAddBundleOptionWithTwoProducts3WaitForPageLoad
		$I->click("//tr[3]//button[@data-index='modal_set']"); // stepKey: clickAddAddBundleOptionWithTwoProducts3
		$I->waitForPageLoad(30); // stepKey: clickAddAddBundleOptionWithTwoProducts3WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters1AddBundleOptionWithTwoProducts3
		$I->waitForPageLoad(30); // stepKey: clickClearFilters1AddBundleOptionWithTwoProducts3WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters1AddBundleOptionWithTwoProducts3
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilter1AddBundleOptionWithTwoProducts3
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters1AddBundleOptionWithTwoProducts3
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters1AddBundleOptionWithTwoProducts3WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad1AddBundleOptionWithTwoProducts3
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct1AddBundleOptionWithTwoProducts3
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters2AddBundleOptionWithTwoProducts3
		$I->waitForPageLoad(30); // stepKey: clickClearFilters2AddBundleOptionWithTwoProducts3WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters2AddBundleOptionWithTwoProducts3
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct2', 'sku', 'test')); // stepKey: fillProductSkuFilter2AddBundleOptionWithTwoProducts3
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters2AddBundleOptionWithTwoProducts3
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters2AddBundleOptionWithTwoProducts3WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad2AddBundleOptionWithTwoProducts3
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct2AddBundleOptionWithTwoProducts3
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddButton1AddBundleOptionWithTwoProducts3
		$I->waitForPageLoad(30); // stepKey: clickAddButton1AddBundleOptionWithTwoProducts3WaitForPageLoad
		$I->fillField("[name='bundle_options[bundle_options][2][bundle_selections][0][selection_qty]']", "50"); // stepKey: fillQuantity1AddBundleOptionWithTwoProducts3
		$I->fillField("[name='bundle_options[bundle_options][2][bundle_selections][1][selection_qty]']", "50"); // stepKey: fillQuantity2AddBundleOptionWithTwoProducts3
		$I->comment("Exiting Action Group [addBundleOptionWithTwoProducts3] AddBundleOptionWithTwoProductsActionGroup");
		$I->comment("Add Option Four, a \"Multi Select\" type option");
		$I->comment("Entering Action Group [addBundleOptionWithTwoProducts4] AddBundleOptionWithTwoProductsActionGroup");
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenSectionBundleItemsAddBundleOptionWithTwoProducts4
		$I->scrollTo("//span[text()='Bundle Items']"); // stepKey: scrollUpABitAddBundleOptionWithTwoProducts4
		$I->click("button[data-index='add_button']"); // stepKey: clickAddOptionAddBundleOptionWithTwoProducts4
		$I->waitForElementVisible("[name='bundle_options[bundle_options][3][title]']", 30); // stepKey: waitForOptionsAddBundleOptionWithTwoProducts4
		$I->fillField("[name='bundle_options[bundle_options][3][title]']", "Option Four"); // stepKey: fillTitleAddBundleOptionWithTwoProducts4
		$I->selectOption("[name='bundle_options[bundle_options][3][type]']", "multi"); // stepKey: selectTypeAddBundleOptionWithTwoProducts4
		$I->waitForElementVisible("//tr[4]//button[@data-index='modal_set']", 30); // stepKey: waitForAddBtnAddBundleOptionWithTwoProducts4
		$I->waitForPageLoad(30); // stepKey: waitForAddBtnAddBundleOptionWithTwoProducts4WaitForPageLoad
		$I->click("//tr[4]//button[@data-index='modal_set']"); // stepKey: clickAddAddBundleOptionWithTwoProducts4
		$I->waitForPageLoad(30); // stepKey: clickAddAddBundleOptionWithTwoProducts4WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters1AddBundleOptionWithTwoProducts4
		$I->waitForPageLoad(30); // stepKey: clickClearFilters1AddBundleOptionWithTwoProducts4WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters1AddBundleOptionWithTwoProducts4
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilter1AddBundleOptionWithTwoProducts4
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters1AddBundleOptionWithTwoProducts4
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters1AddBundleOptionWithTwoProducts4WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad1AddBundleOptionWithTwoProducts4
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct1AddBundleOptionWithTwoProducts4
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters2AddBundleOptionWithTwoProducts4
		$I->waitForPageLoad(30); // stepKey: clickClearFilters2AddBundleOptionWithTwoProducts4WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters2AddBundleOptionWithTwoProducts4
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct2', 'sku', 'test')); // stepKey: fillProductSkuFilter2AddBundleOptionWithTwoProducts4
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters2AddBundleOptionWithTwoProducts4
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters2AddBundleOptionWithTwoProducts4WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad2AddBundleOptionWithTwoProducts4
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct2AddBundleOptionWithTwoProducts4
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddButton1AddBundleOptionWithTwoProducts4
		$I->waitForPageLoad(30); // stepKey: clickAddButton1AddBundleOptionWithTwoProducts4WaitForPageLoad
		$I->fillField("[name='bundle_options[bundle_options][3][bundle_selections][0][selection_qty]']", "50"); // stepKey: fillQuantity1AddBundleOptionWithTwoProducts4
		$I->fillField("[name='bundle_options[bundle_options][3][bundle_selections][1][selection_qty]']", "50"); // stepKey: fillQuantity2AddBundleOptionWithTwoProducts4
		$I->comment("Exiting Action Group [addBundleOptionWithTwoProducts4] AddBundleOptionWithTwoProductsActionGroup");
		$I->comment("Save product and go to storefront");
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
		$I->amOnPage("bundleproduct" . msq("BundleProduct") . ".html"); // stepKey: goToStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefront
		$I->click("#bundle-slide"); // stepKey: clickCustomize
		$I->waitForPageLoad(30); // stepKey: clickCustomizeWaitForPageLoad
		$I->comment("Select all applicable options");
		$I->selectOption("select.bundle-option-select", $I->retrieveEntityField('simpleProduct1', 'name', 'test') . " +$123.00"); // stepKey: selectOption1
		$I->click("input[type='radio']:nth-of-type(1)"); // stepKey: selectOption2
		$I->checkOption("input[type='checkbox']:nth-of-type(1)"); // stepKey: selectOption3
		$I->selectOption("select[multiple='multiple']", $I->retrieveEntityField('simpleProduct1', 'name', 'test') . " +$123.00"); // stepKey: selectOption4
		$I->comment("Customize and add the bundle product to our cart");
		$I->click("#product-addtocart-button"); // stepKey: clickAddToCart1
		$I->waitForPageLoad(30); // stepKey: clickAddToCart1WaitForPageLoad
		$I->dontSee("This is a required field.", "#product-options-wrapper div.field.option:nth-of-type(1)"); // stepKey: validForm1
		$I->dontSee("Please select one of the options.", "#product-options-wrapper div.field.option:nth-of-type(2)"); // stepKey: validForm2
		$I->dontSee("Please select one of the options.", "#product-options-wrapper div.field.option:nth-of-type(3)"); // stepKey: validForm3
		$I->dontSee("This is a required field.", "#product-options-wrapper div.field.option:nth-of-type(4)"); // stepKey: validForm4
		$I->see("You added BundleProduct" . msq("BundleProduct") . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessage
		$I->comment("Verify cart contents");
		$I->comment("Entering Action Group [goToCart] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCart
		$I->comment("Exiting Action Group [goToCart] StorefrontCartPageOpenActionGroup");
		$I->see("Option One", "dl.item-options dt:nth-of-type(1)"); // stepKey: seeOption1
		$I->see("Option Two", "dl.item-options dt:nth-of-type(2)"); // stepKey: seeOption2
		$I->see("Option Three", "dl.item-options dt:nth-of-type(3)"); // stepKey: seeOption3
		$I->see("Option Four", "dl.item-options dt:nth-of-type(4)"); // stepKey: seeOption4
		$I->see("50 x " . $I->retrieveEntityField('simpleProduct1', 'name', 'test') . " $123.00", "dl.item-options dd:nth-of-type(1)"); // stepKey: seeOptionValue1
		$I->see("50 x " . $I->retrieveEntityField('simpleProduct1', 'name', 'test') . " $123.00", "dl.item-options dd:nth-of-type(2)"); // stepKey: seeOptionValue2
		$I->see("50 x " . $I->retrieveEntityField('simpleProduct1', 'name', 'test') . " $123.00", "dl.item-options dd:nth-of-type(3)"); // stepKey: seeOptionValue3
		$I->see("50 x " . $I->retrieveEntityField('simpleProduct1', 'name', 'test') . " $123.00", "dl.item-options dd:nth-of-type(4)"); // stepKey: seeOptionValue4
	}
}
