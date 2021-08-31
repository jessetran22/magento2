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
 * @Title("MC-42765: Validation for negative quantity on bundle products.")
 * @Description("Customer should not be able to add the products to the cart if the quantity is negative value<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/StorefrontValidateQuantityBundleProductsTest.xml<br>")
 * @TestCaseId("MC-42765")
 * @group Bundle
 */
class StorefrontValidateQuantityBundleProductsTestCest
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
		$I->createEntity("createProduct1", "hook", "SimpleProduct2", [], []); // stepKey: createProduct1
		$I->createEntity("createProduct2", "hook", "SimpleProduct2", [], []); // stepKey: createProduct2
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete the bundled product");
		$I->comment("Entering Action Group [deleteBundle] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteBundle
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteBundle
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteBundle
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteBundleWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteBundle
		$I->fillField("input.admin__control-text[name='sku']", "bundleproduct" . msq("BundleProduct")); // stepKey: fillProductSkuFilterDeleteBundle
		$I->fillField("input.admin__control-text[name='name']", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductNameFilterDeleteBundle
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteBundle
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteBundleWaitForPageLoad
		$I->see("bundleproduct" . msq("BundleProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteBundle
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteBundle
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteBundle
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteBundle
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteBundleWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteBundle
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteBundleWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteBundle
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteBundle
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteBundleWaitForPageLoad
		$I->comment("Exiting Action Group [deleteBundle] DeleteProductUsingProductGridActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("createProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("createProduct2", "hook"); // stepKey: deleteSimpleProduct2
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
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontValidateQuantityBundleProductsTest(AcceptanceTester $I)
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
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilter1AddBundleOptionWithTwoProducts1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters1AddBundleOptionWithTwoProducts1
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters1AddBundleOptionWithTwoProducts1WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad1AddBundleOptionWithTwoProducts1
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct1AddBundleOptionWithTwoProducts1
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters2AddBundleOptionWithTwoProducts1
		$I->waitForPageLoad(30); // stepKey: clickClearFilters2AddBundleOptionWithTwoProducts1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters2AddBundleOptionWithTwoProducts1
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createProduct2', 'sku', 'test')); // stepKey: fillProductSkuFilter2AddBundleOptionWithTwoProducts1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters2AddBundleOptionWithTwoProducts1
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters2AddBundleOptionWithTwoProducts1WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad2AddBundleOptionWithTwoProducts1
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct2AddBundleOptionWithTwoProducts1
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddButton1AddBundleOptionWithTwoProducts1
		$I->waitForPageLoad(30); // stepKey: clickAddButton1AddBundleOptionWithTwoProducts1WaitForPageLoad
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][0][selection_qty]']", "50"); // stepKey: fillQuantity1AddBundleOptionWithTwoProducts1
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][1][selection_qty]']", "50"); // stepKey: fillQuantity2AddBundleOptionWithTwoProducts1
		$I->comment("Exiting Action Group [addBundleOptionWithTwoProducts1] AddBundleOptionWithTwoProductsActionGroup");
		$I->checkOption("[name='bundle_options[bundle_options][0][bundle_selections][0][selection_can_change_qty]'][type='checkbox']"); // stepKey: userDefinedQuantitiyOption0Product0
		$I->checkOption("[name='bundle_options[bundle_options][0][bundle_selections][1][selection_can_change_qty]'][type='checkbox']"); // stepKey: userDefinedQuantitiyOption0Product1
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
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilter1AddBundleOptionWithTwoProducts2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters1AddBundleOptionWithTwoProducts2
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters1AddBundleOptionWithTwoProducts2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad1AddBundleOptionWithTwoProducts2
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct1AddBundleOptionWithTwoProducts2
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters2AddBundleOptionWithTwoProducts2
		$I->waitForPageLoad(30); // stepKey: clickClearFilters2AddBundleOptionWithTwoProducts2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters2AddBundleOptionWithTwoProducts2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createProduct2', 'sku', 'test')); // stepKey: fillProductSkuFilter2AddBundleOptionWithTwoProducts2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters2AddBundleOptionWithTwoProducts2
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters2AddBundleOptionWithTwoProducts2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad2AddBundleOptionWithTwoProducts2
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct2AddBundleOptionWithTwoProducts2
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddButton1AddBundleOptionWithTwoProducts2
		$I->waitForPageLoad(30); // stepKey: clickAddButton1AddBundleOptionWithTwoProducts2WaitForPageLoad
		$I->fillField("[name='bundle_options[bundle_options][1][bundle_selections][0][selection_qty]']", "50"); // stepKey: fillQuantity1AddBundleOptionWithTwoProducts2
		$I->fillField("[name='bundle_options[bundle_options][1][bundle_selections][1][selection_qty]']", "50"); // stepKey: fillQuantity2AddBundleOptionWithTwoProducts2
		$I->comment("Exiting Action Group [addBundleOptionWithTwoProducts2] AddBundleOptionWithTwoProductsActionGroup");
		$I->checkOption("[name='bundle_options[bundle_options][1][bundle_selections][0][selection_can_change_qty]'][type='checkbox']"); // stepKey: userDefinedQuantitiyOption1Product0
		$I->checkOption("[name='bundle_options[bundle_options][1][bundle_selections][1][selection_can_change_qty]'][type='checkbox']"); // stepKey: userDefinedQuantitiyOption1Product1
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
		$I->wait(60); // stepKey: waitBeforeIndexerAfterBundle
		$runCronIndexerAfterBundle = $I->magentoCLI("cron:run --group=index", 60); // stepKey: runCronIndexerAfterBundle
		$I->comment($runCronIndexerAfterBundle);
		$I->amOnPage("bundleproduct" . msq("BundleProduct") . ".html"); // stepKey: goToStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefront
		$I->click("#bundle-slide"); // stepKey: clickCustomize
		$I->waitForPageLoad(30); // stepKey: clickCustomizeWaitForPageLoad
		$I->comment("\"Drop-down\" type option");
		$I->selectOption("//label//span[contains(text(), 'Option One')]/../..//div[@class='control']//select", $I->retrieveEntityField('createProduct1', 'name', 'test') . " +$" . $I->retrieveEntityField('createProduct1', 'price', 'test') . ".00"); // stepKey: selectOption0Product0
		$I->seeOptionIsSelected("//label//span[contains(text(), 'Option One')]/../..//div[@class='control']//select", $I->retrieveEntityField('createProduct1', 'name', 'test') . " +$" . $I->retrieveEntityField('createProduct1', 'price', 'test') . ".00"); // stepKey: checkOption0Product0
		$I->fillField("//span[contains(text(), 'Option One')]/../..//input", "-1"); // stepKey: fillQuantity00
		$I->seeInField("//span[contains(text(), 'Option One')]/../..//input", "-1"); // stepKey: checkQuantity00
		$I->click("#product-addtocart-button"); // stepKey: clickAddToCartDropDown
		$I->waitForPageLoad(30); // stepKey: clickAddToCartDropDownWaitForPageLoad
		$I->see("Please enter a quantity greater than 0.", "//span[contains(text(), 'Option One')]/../..//input/following-sibling::div[@class='mage-error']"); // stepKey: seeQuantityNegativeErrorMessageDropDown
		$I->comment("\"Radio Buttons\" type option");
		$I->checkOption("//label//span[contains(text(), 'Option Two')]/../..//div[@class='control']//div[@class='field choice'][1]/input"); // stepKey: selectOption1Product0
		$I->seeCheckboxIsChecked("//label//span[contains(text(), 'Option Two')]/../..//div[@class='control']//div[@class='field choice'][1]/input"); // stepKey: checkOption1Product0
		$I->fillField("//label//span[contains(text(), 'Option Two')]/../..//div[@class='control']//div[@class='field qty qty-holder']//input", "-1"); // stepKey: fillQuantity10
		$I->seeInField("//label//span[contains(text(), 'Option Two')]/../..//div[@class='control']//div[@class='field qty qty-holder']//input", "-1"); // stepKey: checkQuantity10
		$I->click("#product-addtocart-button"); // stepKey: clickAddToCartRadioButton
		$I->waitForPageLoad(30); // stepKey: clickAddToCartRadioButtonWaitForPageLoad
		$I->see("Please enter a quantity greater than 0.", "//label//span[contains(text(), 'Option Two')]/../..//div[@class='control']//div[@class='field qty qty-holder']//input/following-sibling::div[@class='mage-error']"); // stepKey: seeQuantityNegativeErrorMessageRadioButton
	}
}
