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
 * @Title("MAGETWO-93101: Configurable product with swatch option and file custom option")
 * @Description("Configurable product with swatch option and file custom option. When adding to cart with an invalid filetype, the correct error message is shown, and options remain selected.<h3>Test files</h3>app/code/Magento/Swatches/Test/Mftf/Test/StorefrontSwatchProductWithFileCustomOptionTest.xml<br>")
 * @TestCaseId("MAGETWO-93101")
 * @group ConfigurableProduct
 * @group Swatches
 */
class StorefrontSwatchProductWithFileCustomOptionTestCest
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
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Features({"Swatches"})
	 * @Stories({"Add configurable product to cart"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontSwatchProductWithFileCustomOptionTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create a configurable swatch product via the UI");
		$I->comment("Entering Action Group [goToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageGoToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadGoToProductIndex
		$I->comment("Exiting Action Group [goToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [goToCreateProductPage] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleGoToCreateProductPage
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleGoToCreateProductPageWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-configurable']", 30); // stepKey: waitForAddProductDropdownGoToCreateProductPage
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-configurable']"); // stepKey: clickAddProductTypeGoToCreateProductPage
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadGoToCreateProductPage
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/configurable/"); // stepKey: seeNewProductUrlGoToCreateProductPage
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleGoToCreateProductPage
		$I->comment("Exiting Action Group [goToCreateProductPage] GoToCreateProductPageActionGroup");
		$I->comment("Entering Action Group [fillProductForm] FillMainProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillProductForm
		$I->fillField(".admin__field[data-index=name] input", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillProductNameFillProductForm
		$I->fillField(".admin__field[data-index=sku] input", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillProductSkuFillProductForm
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillProductForm
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillProductForm
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillProductForm
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillProductFormWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillProductForm
		$I->fillField(".admin__field[data-index=weight] input", "2"); // stepKey: fillProductWeightFillProductForm
		$I->comment("Exiting Action Group [fillProductForm] FillMainProductFormActionGroup");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: searchAndSelectCategory
		$I->waitForPageLoad(30); // stepKey: searchAndSelectCategoryWaitForPageLoad
		$I->comment("Add swatch attribute to configurable product");
		$I->comment("Entering Action Group [addSwatchToProduct] AddVisualSwatchToProductActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: seeOnProductEditPageAddSwatchToProduct
		$I->conditionalClick(".admin__collapsible-block-wrapper[data-index='configurable']", "button[data-index='create_configurable_products_button']", false); // stepKey: openConfigurationSectionAddSwatchToProduct
		$I->waitForPageLoad(30); // stepKey: openConfigurationSectionAddSwatchToProductWaitForPageLoad
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: openConfigurationPanelAddSwatchToProduct
		$I->waitForPageLoad(30); // stepKey: openConfigurationPanelAddSwatchToProductWaitForPageLoad
		$I->waitForElementVisible(".select-attributes-actions button[title='Create New Attribute']", 30); // stepKey: waitForSlideOutAddSwatchToProduct
		$I->waitForPageLoad(30); // stepKey: waitForSlideOutAddSwatchToProductWaitForPageLoad
		$I->click(".select-attributes-actions button[title='Create New Attribute']"); // stepKey: clickCreateNewAttributeAddSwatchToProduct
		$I->waitForPageLoad(30); // stepKey: clickCreateNewAttributeAddSwatchToProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForIFrameAddSwatchToProduct
		$I->switchToIFrame("create_new_attribute_container"); // stepKey: switchToNewAttributeIFrameAddSwatchToProduct
		$I->fillField("input[name='frontend_label[0]']", "VisualSwatchAttr" . msq("visualSwatchAttribute")); // stepKey: fillDefaultLabelAddSwatchToProduct
		$I->selectOption("select[name='frontend_input']", "Visual Swatch"); // stepKey: selectInputTypeAddSwatchToProduct
		$I->waitForPageLoad(30); // stepKey: selectInputTypeAddSwatchToProductWaitForPageLoad
		$I->comment("Add swatch options");
		$I->click("button#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch1AddSwatchToProduct
		$I->waitForElementVisible("[data-role='swatch-visual-options-container'] input[name='optionvisual[value][option_0][0]']", 30); // stepKey: waitForOption1RowAddSwatchToProduct
		$I->fillField("[data-role='swatch-visual-options-container'] input[name='optionvisual[value][option_0][0]']", "VisualOpt1" . msq("visualSwatchOption1")); // stepKey: fillAdminLabel1AddSwatchToProduct
		$I->fillField("[data-role='swatch-visual-options-container'] input[name='optionvisual[value][option_0][1]']", "VisualOpt1" . msq("visualSwatchOption1")); // stepKey: fillDefaultStoreLabel1AddSwatchToProduct
		$I->click("button#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch2AddSwatchToProduct
		$I->waitForElementVisible("[data-role='swatch-visual-options-container'] input[name='optionvisual[value][option_1][0]']", 30); // stepKey: waitForOption2RowAddSwatchToProduct
		$I->fillField("[data-role='swatch-visual-options-container'] input[name='optionvisual[value][option_1][0]']", "VisualOpt2" . msq("visualSwatchOption2")); // stepKey: fillAdminLabel2AddSwatchToProduct
		$I->fillField("[data-role='swatch-visual-options-container'] input[name='optionvisual[value][option_1][1]']", "VisualOpt2" . msq("visualSwatchOption2")); // stepKey: fillDefaultStoreLabel2AddSwatchToProduct
		$I->comment("Save attribute");
		$I->click("#save"); // stepKey: clickOnNewAttributePanelAddSwatchToProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveAttributeAddSwatchToProduct
		$I->switchToIFrame(); // stepKey: switchOutOfIFrameAddSwatchToProduct
		$I->comment("Find attribute in grid and select");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersAddSwatchToProduct
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersAddSwatchToProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickOnFiltersAddSwatchToProduct
		$I->waitForPageLoad(30); // stepKey: clickOnFiltersAddSwatchToProductWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='attribute_code']", "VisualSwatchAttr" . msq("visualSwatchAttribute")); // stepKey: fillFilterAttributeCodeFieldAddSwatchToProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonAddSwatchToProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonAddSwatchToProductWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1) td.data-grid-checkbox-cell input"); // stepKey: clickOnFirstCheckboxAddSwatchToProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickNextStep1AddSwatchToProduct
		$I->waitForPageLoad(30); // stepKey: clickNextStep1AddSwatchToProductWaitForPageLoad
		$I->click("//div[@data-attribute-title='VisualSwatchAttr" . msq("visualSwatchAttribute") . "']//button[contains(@class, 'action-select-all')]"); // stepKey: clickSelectAllAddSwatchToProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickNextStep2AddSwatchToProduct
		$I->waitForPageLoad(30); // stepKey: clickNextStep2AddSwatchToProductWaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuAddSwatchToProduct
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuAddSwatchToProductWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "100"); // stepKey: enterAttributeQuantityAddSwatchToProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextStep3AddSwatchToProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextStep3AddSwatchToProductWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: generateProductsAddSwatchToProduct
		$I->waitForPageLoad(30); // stepKey: generateProductsAddSwatchToProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: saveProductAddSwatchToProduct
		$I->waitForPageLoad(30); // stepKey: saveProductAddSwatchToProductWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmInPopupAddSwatchToProduct
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupAddSwatchToProductWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSaveProductMessageAddSwatchToProduct
		$I->comment("Exiting Action Group [addSwatchToProduct] AddVisualSwatchToProductActionGroup");
		$I->comment("Add custom option to configurable product");
		$I->comment("Entering Action Group [addCustomOptionToProduct] AddProductCustomOptionFileActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "button[data-index='button_add']", false); // stepKey: openCustomOptionSectionAddCustomOptionToProduct
		$I->waitForPageLoad(30); // stepKey: openCustomOptionSectionAddCustomOptionToProductWaitForPageLoad
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionAddCustomOptionToProduct
		$I->waitForPageLoad(30); // stepKey: clickAddOptionAddCustomOptionToProductWaitForPageLoad
		$I->waitForElementVisible("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, '_required')]//input", 30); // stepKey: waitForOptionAddCustomOptionToProduct
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, '_required')]//input", "OptionFile"); // stepKey: fillTitleAddCustomOptionToProduct
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__action-multiselect-text')]"); // stepKey: openTypeSelectAddCustomOptionToProduct
		$I->click("//*[@data-index='custom_options']//label[text()='File'][ancestor::*[contains(@class, '_active')]]"); // stepKey: selectTypeFileAddCustomOptionToProduct
		$I->waitForElementVisible("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'OptionFile')]/ancestor::tr//*[@data-index='price']//input", 30); // stepKey: waitForElementsAddCustomOptionToProduct
		$I->fillField("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'OptionFile')]/ancestor::tr//*[@data-index='price']//input", "9.99"); // stepKey: fillPriceAddCustomOptionToProduct
		$I->selectOption("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'OptionFile')]/ancestor::tr//*[@data-index='price_type']//select", "fixed"); // stepKey: selectPriceTypeAddCustomOptionToProduct
		$I->fillField("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'OptionFile')]/ancestor::tr//*[@data-index='file_extension']//input", "png, jpg, gif"); // stepKey: fillCompatibleExtensionsAddCustomOptionToProduct
		$I->comment("Exiting Action Group [addCustomOptionToProduct] AddProductCustomOptionFileActionGroup");
		$I->comment("Entering Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: saveProductSaveProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveProduct
		$I->comment("Exiting Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->comment("Go to storefront");
		$I->amOnPage(""); // stepKey: goToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForHomePageLoad
		$I->click("//a[contains(@class,'level-top')]/span[contains(text(),'" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]"); // stepKey: goToCategoryStorefront
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoad
		$I->see($I->retrieveEntityField('createCategory', 'name', 'test'), "#page-title-heading span"); // stepKey: seeOnCategoryPage
		$I->comment("Add configurable product to cart");
		$I->moveMouseOver("//main//li//a[contains(text(), 'configurable" . msq("BaseConfigurableProduct") . "')]"); // stepKey: hoverProductInGrid
		$I->click("//main//li[.//a[contains(text(), 'configurable" . msq("BaseConfigurableProduct") . "')]]//button[contains(@class, 'tocart')]"); // stepKey: tryAddToCartFromCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForRedirectToProductPage
		$I->seeInCurrentUrl("/configurable" . msq("BaseConfigurableProduct") . ".html"); // stepKey: seeOnProductPage
		$I->click("div.swatch-option[data-option-label='VisualOpt2" . msq("visualSwatchOption2") . "']"); // stepKey: clickSwatchOption
		$I->see("VisualOpt2" . msq("visualSwatchOption2"), "//div[contains(@class, 'swatch-attribute') and contains(., 'VisualSwatchAttr" . msq("visualSwatchAttribute") . "')]//span[contains(@class, 'swatch-attribute-selected-option')]"); // stepKey: seeSwatchIsSelected
		$I->comment("Try invalid file");
		$I->attachFile("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionFile')]/../div[@class='control']//input[@type='file']", "lorem_ipsum.docx"); // stepKey: attachInvalidFile
		$I->click("button.action.tocart.primary"); // stepKey: addToCartInvalidFile
		$I->waitForPageLoad(30); // stepKey: addToCartInvalidFileWaitForPageLoad
		$I->waitForElementVisible(".page.messages [role=alert]", 30); // stepKey: waitForErrorMessageInvalidFile
		$I->see("The file 'lorem_ipsum.docx' for 'OptionFile' has an invalid extension.", ".page.messages"); // stepKey: seeMessageInvalidFile
		$I->waitForPageLoad(30); // stepKey: seeMessageInvalidFileWaitForPageLoad
		$I->comment("Swatch remains selected");
		$I->see("VisualOpt2" . msq("visualSwatchOption2"), "//div[contains(@class, 'swatch-attribute') and contains(., 'VisualSwatchAttr" . msq("visualSwatchAttribute") . "')]//span[contains(@class, 'swatch-attribute-selected-option')]"); // stepKey: seeSwatchRemainsSelected
		$I->comment("Try valid file");
		$I->attachFile("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionFile')]/../div[@class='control']//input[@type='file']", "magento-logo.png"); // stepKey: attachValidFile
		$I->see("$132.99", "div.price-box.price-final_price"); // stepKey: seePriceUpdated
		$I->click("button.action.tocart.primary"); // stepKey: addToCartValidFile
		$I->waitForPageLoad(30); // stepKey: addToCartValidFileWaitForPageLoad
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessage
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageWaitForPageLoad
		$I->see("You added configurable" . msq("BaseConfigurableProduct") . " to your shopping cart.", ".page.messages"); // stepKey: seeSuccessMessage
		$I->waitForPageLoad(30); // stepKey: seeSuccessMessageWaitForPageLoad
		$I->comment("Check item in cart");
		$I->comment("Entering Action Group [goToCart] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCart
		$I->comment("Exiting Action Group [goToCart] StorefrontCartPageOpenActionGroup");
		$I->seeElement("//main//table[@id='shopping-cart-table']//tbody//tr//strong[contains(@class, 'product-item-name')]//a[contains(text(), 'configurable" . msq("BaseConfigurableProduct") . "')]"); // stepKey: seeProductInCart
		$I->see("VisualOpt2" . msq("visualSwatchOption2"), "//main//table[@id='shopping-cart-table']//tbody//tr[.//strong[contains(@class, 'product-item-name')]//a[contains(text(), 'configurable" . msq("BaseConfigurableProduct") . "')]]//dl[@class='item-options']//dt[.='VisualSwatchAttr" . msq("visualSwatchAttribute") . "']/following-sibling::dd[1]"); // stepKey: seeSelectedSwatch
		$I->see("magento-logo.png", "//main//table[@id='shopping-cart-table']//tbody//tr[.//strong[contains(@class, 'product-item-name')]//a[contains(text(), 'configurable" . msq("BaseConfigurableProduct") . "')]]//dl[@class='item-options']//dt[.='OptionFile']/following-sibling::dd[1]"); // stepKey: seeCorrectOptionFile
		$I->comment("Delete cart item");
		$I->click("//table[@id='shopping-cart-table']//tbody//tr[contains(@class,'item-actions')]//a[contains(@class,'action-delete')]"); // stepKey: deleteCartItem
		$I->comment("Delete product");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillProductSkuFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("configurable" . msq("BaseConfigurableProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteProduct
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductBySkuActionGroup");
	}
}
