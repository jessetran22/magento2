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
 * @Title("MC-3461: Customers can filter products using image swatches")
 * @Description("Customers can filter products using image swatches<h3>Test files</h3>app/code/Magento/Swatches/Test/Mftf/Test/StorefrontFilterByImageSwatchTest.xml<br>")
 * @TestCaseId("MC-3461")
 * @group Swatches
 */
class StorefrontFilterByImageSwatchTestCest
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
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct
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
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
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
	 * @Stories({"View swatches in product listing"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontFilterByImageSwatchTest(AcceptanceTester $I)
	{
		$I->comment("Begin creating a new product attribute");
		$I->comment("Entering Action Group [goToNewProductAttributePage] AdminNavigateToNewProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute/new/"); // stepKey: goToNewProductAttributePageGoToNewProductAttributePage
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadGoToNewProductAttributePage
		$I->comment("Exiting Action Group [goToNewProductAttributePage] AdminNavigateToNewProductAttributePageActionGroup");
		$I->fillField("#attribute_label", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: fillDefaultLabel
		$I->comment("Select visual swatch");
		$I->selectOption("#frontend_input", "swatch_visual"); // stepKey: selectInputType
		$I->comment("Set Update Product Preview Image to Yes");
		$I->selectOption("[name='update_product_preview_image']", "Yes"); // stepKey: setUpdateProductPreviewImage
		$I->comment("This hack is because the same <input type=\"file\"> is re-purposed used for all uploads.");
		$disableClick = $I->executeJS("HTMLInputElement.prototype.click = function() { if(this.type !== 'file') HTMLElement.prototype.click.call(this); };"); // stepKey: disableClick
		$I->comment("Set swatch #1 image using file upload");
		$I->click("#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch1
		$I->waitForPageLoad(30); // stepKey: clickAddSwatch1WaitForPageLoad
		$I->comment("Entering Action Group [clickSwatch1] OpenSwatchMenuByIndexActionGroup");
		$I->comment("I had to use executeJS to perform the click to get around the use of CSS ::before and ::after");
		$clickSwatch1ClickSwatch1 = $I->executeJS("jQuery('#swatch_window_option_option_0').click()"); // stepKey: clickSwatch1ClickSwatch1
		$I->comment("Exiting Action Group [clickSwatch1] OpenSwatchMenuByIndexActionGroup");
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(1) .swatch_row_name.btn_choose_file_upload"); // stepKey: clickUploadFile1
		$I->attachFile("input[name='datafile']", "adobe-thumb.jpg"); // stepKey: attachFile1
		$I->waitForPageLoad(30); // stepKey: waitFileAttached1
		$I->fillField("optionvisual[value][option_0][0]", "adobe-thumb"); // stepKey: fillAdmin1
		$I->comment("Set swatch #2 image using the file upload");
		$I->click("#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch2
		$I->waitForPageLoad(30); // stepKey: clickAddSwatch2WaitForPageLoad
		$I->comment("Entering Action Group [clickSwatch2] OpenSwatchMenuByIndexActionGroup");
		$I->comment("I had to use executeJS to perform the click to get around the use of CSS ::before and ::after");
		$clickSwatch1ClickSwatch2 = $I->executeJS("jQuery('#swatch_window_option_option_1').click()"); // stepKey: clickSwatch1ClickSwatch2
		$I->comment("Exiting Action Group [clickSwatch2] OpenSwatchMenuByIndexActionGroup");
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(2) .swatch_row_name.btn_choose_file_upload"); // stepKey: clickUploadFile2
		$I->attachFile("input[name='datafile']", "adobe-small.jpg"); // stepKey: attachFile2
		$I->waitForPageLoad(30); // stepKey: waitFileAttached2
		$I->fillField("optionvisual[value][option_1][0]", "adobe-small"); // stepKey: fillAdmin2
		$I->comment("Set scope to global");
		$I->click("#advanced_fieldset-wrapper"); // stepKey: expandAdvancedProperties
		$I->selectOption("#is_global", "1"); // stepKey: selectGlobalScope
		$I->comment("Set Use In Layered Navigation");
		$I->scrollToTopOfPage(); // stepKey: scrollToTop1
		$I->click("#product_attribute_tabs_front"); // stepKey: goToStorefrontProperties
		$I->selectOption("#is_filterable", "1"); // stepKey: selectUseInLayeredNavigation
		$I->comment("Save the new attribute");
		$I->click("#save_and_edit_button"); // stepKey: clickSaveAndEdit1
		$I->waitForPageLoad(30); // stepKey: clickSaveAndEdit1WaitForPageLoad
		$I->waitForElementVisible(".message.message-success.success", 30); // stepKey: waitForSuccess
		$I->comment("Create a configurable product to verify the storefront with");
		$I->comment("Entering Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductGridPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductGridPage
		$I->comment("Exiting Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [goToCreateConfigurableProduct] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleGoToCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleGoToCreateConfigurableProductWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-configurable']", 30); // stepKey: waitForAddProductDropdownGoToCreateConfigurableProduct
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-configurable']"); // stepKey: clickAddProductTypeGoToCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadGoToCreateConfigurableProduct
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/configurable/"); // stepKey: seeNewProductUrlGoToCreateConfigurableProduct
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleGoToCreateConfigurableProduct
		$I->comment("Exiting Action Group [goToCreateConfigurableProduct] GoToCreateProductPageActionGroup");
		$I->comment("Add image to configurable product");
		$I->comment("Entering Action Group [addFirstImageForProductConfigurable] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddFirstImageForProductConfigurable
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddFirstImageForProductConfigurable
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddFirstImageForProductConfigurable
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileAddFirstImageForProductConfigurable
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddFirstImageForProductConfigurable
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddFirstImageForProductConfigurable
		$I->comment("Exiting Action Group [addFirstImageForProductConfigurable] AddProductImageActionGroup");
		$I->comment("Add image to configurable product");
		$I->comment("Entering Action Group [addSecondImageForProductConfigurable] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddSecondImageForProductConfigurable
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddSecondImageForProductConfigurable
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddSecondImageForProductConfigurable
		$I->attachFile("#fileupload", "magento-again.jpg"); // stepKey: uploadFileAddSecondImageForProductConfigurable
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddSecondImageForProductConfigurable
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]", 30); // stepKey: waitForThumbnailAddSecondImageForProductConfigurable
		$I->comment("Exiting Action Group [addSecondImageForProductConfigurable] AddProductImageActionGroup");
		$I->comment("Entering Action Group [fillProductForm] FillMainProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillProductForm
		$I->fillField(".admin__field[data-index=name] input", "API Configurable Product" . msq("ApiConfigurableProduct")); // stepKey: fillProductNameFillProductForm
		$I->fillField(".admin__field[data-index=sku] input", "api-configurable-product" . msq("ApiConfigurableProduct")); // stepKey: fillProductSkuFillProductForm
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillProductForm
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillProductForm
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillProductForm
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillProductFormWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillProductForm
		$I->fillField(".admin__field[data-index=weight] input", "2"); // stepKey: fillProductWeightFillProductForm
		$I->comment("Exiting Action Group [fillProductForm] FillMainProductFormActionGroup");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: fillCategory
		$I->waitForPageLoad(30); // stepKey: fillCategoryWaitForPageLoad
		$I->comment("Create configurations based off the visual swatch we created earlier");
		$I->comment("Entering Action Group [createConfigurations] CreateConfigurationsForAttributeWithImagesActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurationsCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsCreateConfigurationsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersCreateConfigurations
		$I->fillField(".admin__control-text[name='attribute_code']", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: fillFilterAttributeCodeFieldCreateConfigurations
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonCreateConfigurationsWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxCreateConfigurations
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1CreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1CreateConfigurationsWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllCreateConfigurations
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2CreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2CreateConfigurationsWaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuCreateConfigurationsWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "99"); // stepKey: enterAttributeQuantityCreateConfigurations
		$I->click(".admin__field-label[for='apply-single-set-radio']"); // stepKey: clickOnApplySingleImageSetToAllSkuCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleImageSetToAllSkuCreateConfigurationsWaitForPageLoad
		$I->waitForElementVisible(".steps-wizard-section div.gallery", 30); // stepKey: seeImageSectionIsReadyCreateConfigurations
		$I->attachFile(".steps-wizard-section input[type='file'][name='image']", "adobe-base.jpg"); // stepKey: uploadFileCreateConfigurations
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadCreateConfigurations
		$I->waitForElementVisible("//*[@data-role='gallery']//img[contains(@src, 'adobe-base')]", 30); // stepKey: waitForThumbnailCreateConfigurations
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3CreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3CreateConfigurationsWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4CreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4CreateConfigurationsWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButton2CreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButton2CreateConfigurationsWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmInPopupCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupCreateConfigurationsWaitForPageLoad
		$I->comment("Exiting Action Group [createConfigurations] CreateConfigurationsForAttributeWithImagesActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Go to the category page");
		$I->amOnPage($I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPage
		$I->comment("Verify swatches are present in the layered navigation");
		$I->see("attribute" . msq("ProductAttributeFrontendLabel"), "#layered-filter-block"); // stepKey: seeAttributeInLayeredNav
		$I->click("//div[@class='filter-options-title'][text() = 'attribute" . msq("ProductAttributeFrontendLabel") . "']"); // stepKey: expandAttribute
		$I->waitForPageLoad(30); // stepKey: expandAttributeWaitForPageLoad
		$grabSwatch1 = $I->grabAttributeFrom("div.attribute" . msq("ProductAttributeFrontendLabel") . " a:nth-of-type(1) div", "style"); // stepKey: grabSwatch1
		$I->waitForPageLoad(30); // stepKey: grabSwatch1WaitForPageLoad
		$grabSwatch2 = $I->grabAttributeFrom("div.attribute" . msq("ProductAttributeFrontendLabel") . " a:nth-of-type(2) div", "style"); // stepKey: grabSwatch2
		$I->waitForPageLoad(30); // stepKey: grabSwatch2WaitForPageLoad
		$I->assertStringContainsString("adobe-thumb", $grabSwatch1); // stepKey: assertSwatch1
		$I->assertStringContainsString("adobe-small", $grabSwatch2); // stepKey: assertSwatch2
		$I->comment("Click a swatch and expect to see the configurable product, not see the simple product");
		$I->click("div.attribute" . msq("ProductAttributeFrontendLabel") . " a:nth-of-type(1) div"); // stepKey: filterBySwatch1
		$I->waitForPageLoad(30); // stepKey: filterBySwatch1WaitForPageLoad
		$I->see("API Configurable Product" . msq("ApiConfigurableProduct"), ".product-item-info"); // stepKey: seeConfigurableProduct
		$I->dontSee($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".product-item-info"); // stepKey: dontSeeSimpleProduct
		$I->comment("Assert configurable product in storefront product page");
		$I->comment("Entering Action Group [AssertProductInStorefrontProductPage] AssertProductInStorefrontProductPageActionGroup");
		$I->comment("Go to storefront product page, assert product name, sku and price");
		$I->amOnPage("api-configurable-product" . msq("ApiConfigurableProduct") . ".html"); // stepKey: navigateToProductPageAssertProductInStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssertProductInStorefrontProductPage
		$I->seeInTitle("API Configurable Product" . msq("ApiConfigurableProduct")); // stepKey: assertProductNameTitleAssertProductInStorefrontProductPage
		$I->see("API Configurable Product" . msq("ApiConfigurableProduct"), ".base"); // stepKey: assertProductNameAssertProductInStorefrontProductPage
		$I->see("123.00", "div.price-box.price-final_price"); // stepKey: assertProductPriceAssertProductInStorefrontProductPage
		$I->see("api-configurable-product" . msq("ApiConfigurableProduct"), ".product.attribute.sku>.value"); // stepKey: assertProductSkuAssertProductInStorefrontProductPage
		$I->comment("Exiting Action Group [AssertProductInStorefrontProductPage] AssertProductInStorefrontProductPageActionGroup");
		$I->comment("Assert configurable product image in storefront product page");
		$I->comment("Entering Action Group [assertProductImageStorefrontProductPage] AssertProductImageStorefrontProductPageActionGroup");
		$I->seeInCurrentUrl("/api-configurable-product" . msq("ApiConfigurableProduct") . ".html"); // stepKey: checkUrlAssertProductImageStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProductImageStorefrontProductPage
		$I->seeElement("//*[@class='product media']//img[contains(@src, 'magento-logo')]"); // stepKey: seeImageAssertProductImageStorefrontProductPage
		$I->comment("Exiting Action Group [assertProductImageStorefrontProductPage] AssertProductImageStorefrontProductPageActionGroup");
		$I->comment("Assert configurable product image in storefront product page");
		$I->comment("Entering Action Group [assertProductSecondImageStorefrontProductPage] AssertProductImageStorefrontProductPageActionGroup");
		$I->seeInCurrentUrl("/api-configurable-product" . msq("ApiConfigurableProduct") . ".html"); // stepKey: checkUrlAssertProductSecondImageStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProductSecondImageStorefrontProductPage
		$I->seeElement("//*[@class='product media']//img[contains(@src, 'magento-again')]"); // stepKey: seeImageAssertProductSecondImageStorefrontProductPage
		$I->comment("Exiting Action Group [assertProductSecondImageStorefrontProductPage] AssertProductImageStorefrontProductPageActionGroup");
		$I->comment("Click a swatch and expect to see the image from the swatch from the configurable product");
		$I->click("div.swatch-option[data-option-label='adobe-thumb']"); // stepKey: clickSwatchOption
		$I->comment("Assert swatch option image for configurable product image in storefront product page");
		$I->comment("Entering Action Group [assertSwatchImageStorefrontProductPage] AssertProductImageStorefrontProductPageActionGroup");
		$I->seeInCurrentUrl("/api-configurable-product" . msq("ApiConfigurableProduct") . ".html"); // stepKey: checkUrlAssertSwatchImageStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertSwatchImageStorefrontProductPage
		$I->seeElement("//*[@class='product media']//img[contains(@src, 'adobe-base')]"); // stepKey: seeImageAssertSwatchImageStorefrontProductPage
		$I->comment("Exiting Action Group [assertSwatchImageStorefrontProductPage] AssertProductImageStorefrontProductPageActionGroup");
	}
}
