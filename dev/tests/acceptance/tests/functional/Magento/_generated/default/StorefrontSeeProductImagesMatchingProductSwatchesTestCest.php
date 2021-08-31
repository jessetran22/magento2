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
 * @Title("MC-3086: Customer can see product images matching product swatches")
 * @Description("Customer can see product images matching product swatches<h3>Test files</h3>app/code/Magento/Swatches/Test/Mftf/Test/StorefrontSeeProductImagesMatchingProductSwatchesTest.xml<br>")
 * @TestCaseId("MC-3086")
 * @group swatches
 */
class StorefrontSeeProductImagesMatchingProductSwatchesTestCest
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
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
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
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Entering Action Group [deleteAttribute] DeleteProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteAttribute
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAttributeWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", "visual_swatch" . msq("VisualSwatchProductAttribute")); // stepKey: setAttributeCodeDeleteAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridDeleteAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2DeleteAttribute
		$I->click("#delete"); // stepKey: deleteAttributeDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteAttributeWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: ClickOnDeleteButtonDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: ClickOnDeleteButtonDeleteAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteAttribute
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessageDeleteAttribute
		$I->comment("Exiting Action Group [deleteAttribute] DeleteProductAttributeActionGroup");
		$I->comment("Entering Action Group [clearProductAttributeGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearProductAttributeGridFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearProductAttributeGridFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductAttributeGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [deleteAllChildrenProducts] DeleteAllDuplicateProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteAllChildrenProducts
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteAllChildrenProducts
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteAllChildrenProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteAllChildrenProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteAllChildrenProducts
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'hook')); // stepKey: fillProductSkuFilterDeleteAllChildrenProducts
		$I->fillField("input.admin__control-text[name='name']", $I->retrieveEntityField('createSimpleProduct', 'name', 'hook')); // stepKey: fillProductNameFilterDeleteAllChildrenProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteAllChildrenProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteAllChildrenProductsWaitForPageLoad
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteAllChildrenProducts
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteAllChildrenProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteAllChildrenProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteAllChildrenProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteAllChildrenProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteAllChildrenProductsWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteAllChildrenProducts
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteAllChildrenProducts
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteAllChildrenProductsWaitForPageLoad
		$I->comment("Exiting Action Group [deleteAllChildrenProducts] DeleteAllDuplicateProductUsingProductGridActionGroup");
		$I->comment("Entering Action Group [clearProductGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearProductGridFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearProductGridFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductGridFilter] ClearFiltersAdminDataGridActionGroup");
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
	 * @Features({"Swatches"})
	 * @Stories({"Swatches in product details page"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontSeeProductImagesMatchingProductSwatchesTest(AcceptanceTester $I)
	{
		$I->comment("Begin creating a new product attribute");
		$I->comment("Entering Action Group [goToNewProductAttributePage] AdminNavigateToNewProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute/new/"); // stepKey: goToNewProductAttributePageGoToNewProductAttributePage
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadGoToNewProductAttributePage
		$I->comment("Exiting Action Group [goToNewProductAttributePage] AdminNavigateToNewProductAttributePageActionGroup");
		$I->comment("Entering Action Group [fillProductAttributeProperties] AdminFillProductAttributePropertiesActionGroup");
		$I->fillField("#attribute_label", "visual_swatch" . msq("VisualSwatchProductAttribute")); // stepKey: fillDefaultLabelFillProductAttributeProperties
		$I->selectOption("#frontend_input", "swatch_visual"); // stepKey: selectInputTypeFillProductAttributeProperties
		$I->comment("Exiting Action Group [fillProductAttributeProperties] AdminFillProductAttributePropertiesActionGroup");
		$I->comment("Select value for option \"Update Product Preview Image\"");
		$I->comment("Entering Action Group [setUpdateProductPreviewImage] AdminUpdateProductPreviewImageActionGroup");
		$I->selectOption("[name='update_product_preview_image']", "Yes"); // stepKey: setUpdateProductPreviewImageSetUpdateProductPreviewImage
		$I->comment("Exiting Action Group [setUpdateProductPreviewImage] AdminUpdateProductPreviewImageActionGroup");
		$I->comment("Entering Action Group [addFirstSwatchOptionAndFillFields] AdminAddSwatchOptionAndFillFieldsActionGroup");
		$I->click("button#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatchAddFirstSwatchOptionAndFillFields
		$I->waitForElementVisible("[data-role='swatch-visual-options-container'] tr:last-child [name*='][0]']", 30); // stepKey: waitForOption1RowAddFirstSwatchOptionAndFillFields
		$I->fillField("[data-role='swatch-visual-options-container'] tr:last-child [name*='][0]']", "VisualOpt1" . msq("visualSwatchOption1")); // stepKey: fillAdminLabelAddFirstSwatchOptionAndFillFields
		$I->fillField("[data-role='swatch-visual-options-container'] tr:last-child [name*='][1]']", "VisualOpt1" . msq("visualSwatchOption1")); // stepKey: fillDefaultStoreLabelAddFirstSwatchOptionAndFillFields
		$I->comment("Exiting Action Group [addFirstSwatchOptionAndFillFields] AdminAddSwatchOptionAndFillFieldsActionGroup");
		$I->comment("Entering Action Group [addSecondSwatchOptionAndFillFields] AdminAddSwatchOptionAndFillFieldsActionGroup");
		$I->click("button#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatchAddSecondSwatchOptionAndFillFields
		$I->waitForElementVisible("[data-role='swatch-visual-options-container'] tr:last-child [name*='][0]']", 30); // stepKey: waitForOption1RowAddSecondSwatchOptionAndFillFields
		$I->fillField("[data-role='swatch-visual-options-container'] tr:last-child [name*='][0]']", "VisualOpt2" . msq("visualSwatchOption2")); // stepKey: fillAdminLabelAddSecondSwatchOptionAndFillFields
		$I->fillField("[data-role='swatch-visual-options-container'] tr:last-child [name*='][1]']", "VisualOpt2" . msq("visualSwatchOption2")); // stepKey: fillDefaultStoreLabelAddSecondSwatchOptionAndFillFields
		$I->comment("Exiting Action Group [addSecondSwatchOptionAndFillFields] AdminAddSwatchOptionAndFillFieldsActionGroup");
		$I->comment("Set scope to global");
		$I->comment("Entering Action Group [switchScopeForProductAttribute] AdminSwitchScopeForProductAttributeActionGroup");
		$I->click("#advanced_fieldset-wrapper"); // stepKey: expandAdvancedPropertiesSwitchScopeForProductAttribute
		$I->waitForElementVisible("#is_global", 30); // stepKey: waitOpenAdvancedPropertiesSwitchScopeForProductAttribute
		$I->selectOption("#is_global", "1"); // stepKey: selectNecessaryScopeSwitchScopeForProductAttribute
		$I->comment("Exiting Action Group [switchScopeForProductAttribute] AdminSwitchScopeForProductAttributeActionGroup");
		$I->comment("Save the new attribute");
		$I->comment("Entering Action Group [clickSaveAttribute] ClickSaveButtonActionGroup");
		$I->click("#save"); // stepKey: clickSaveClickSaveAttribute
		$I->waitForPageLoad(30); // stepKey: clickSaveClickSaveAttributeWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitMessageClickSaveAttribute
		$I->see("You saved the product attribute.", "#messages div.message-success"); // stepKey: verifyMessageClickSaveAttribute
		$I->comment("Exiting Action Group [clickSaveAttribute] ClickSaveButtonActionGroup");
		$I->comment("Edit configurable product");
		$I->comment("Entering Action Group [openProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createSimpleProduct', 'id', 'test')); // stepKey: goToProductOpenProductEditPage
		$I->comment("Exiting Action Group [openProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Add images to configurable product");
		$I->comment("Entering Action Group [addFirstImageForProductConfigurable] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddFirstImageForProductConfigurable
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddFirstImageForProductConfigurable
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddFirstImageForProductConfigurable
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileAddFirstImageForProductConfigurable
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddFirstImageForProductConfigurable
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddFirstImageForProductConfigurable
		$I->comment("Exiting Action Group [addFirstImageForProductConfigurable] AddProductImageActionGroup");
		$I->comment("Entering Action Group [addSecondImageForProductConfigurable] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddSecondImageForProductConfigurable
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddSecondImageForProductConfigurable
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddSecondImageForProductConfigurable
		$I->attachFile("#fileupload", "magento-again.jpg"); // stepKey: uploadFileAddSecondImageForProductConfigurable
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddSecondImageForProductConfigurable
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]", 30); // stepKey: waitForThumbnailAddSecondImageForProductConfigurable
		$I->comment("Exiting Action Group [addSecondImageForProductConfigurable] AddProductImageActionGroup");
		$I->comment("Create configurations based off the visual swatch we created earlier");
		$I->comment("Entering Action Group [createConfigurations] StartCreateConfigurationsForAttributeActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurationsCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsCreateConfigurationsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersCreateConfigurations
		$I->fillField(".admin__control-text[name='attribute_code']", "visual_swatch" . msq("VisualSwatchProductAttribute")); // stepKey: fillFilterAttributeCodeFieldCreateConfigurations
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
		$I->comment("Exiting Action Group [createConfigurations] StartCreateConfigurationsForAttributeActionGroup");
		$I->comment("Add images to configurable product attribute options");
		$I->comment("Entering Action Group [addImageToConfigurableProductOptionOne] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-images-radio']"); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionOne
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionOneWaitForPageLoad
		$I->selectOption("#apply-images-attributes", "visual_swatch" . msq("VisualSwatchProductAttribute")); // stepKey: selectOptionAddImageToConfigurableProductOptionOne
		$I->waitForPageLoad(30); // stepKey: selectOptionAddImageToConfigurableProductOptionOneWaitForPageLoad
		$I->attachFile("//*[text()='VisualOpt1" . msq("visualSwatchOption1") . "']/../../div[@data-role='gallery']//input[@type='file']", "adobe-base.jpg"); // stepKey: uploadFileAddImageToConfigurableProductOptionOne
		$I->waitForPageLoad(30); // stepKey: uploadFileAddImageToConfigurableProductOptionOneWaitForPageLoad
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageToConfigurableProductOptionOne
		$I->waitForElementVisible("//*[@data-role='gallery']//img[contains(@src, 'adobe-base')]", 30); // stepKey: waitForThumbnailAddImageToConfigurableProductOptionOne
		$I->comment("Exiting Action Group [addImageToConfigurableProductOptionOne] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->comment("Entering Action Group [addImageToConfigurableProductOptionTwo] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-images-radio']"); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionTwo
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionTwoWaitForPageLoad
		$I->selectOption("#apply-images-attributes", "visual_swatch" . msq("VisualSwatchProductAttribute")); // stepKey: selectOptionAddImageToConfigurableProductOptionTwo
		$I->waitForPageLoad(30); // stepKey: selectOptionAddImageToConfigurableProductOptionTwoWaitForPageLoad
		$I->attachFile("//*[text()='VisualOpt2" . msq("visualSwatchOption2") . "']/../../div[@data-role='gallery']//input[@type='file']", "magento3.jpg"); // stepKey: uploadFileAddImageToConfigurableProductOptionTwo
		$I->waitForPageLoad(30); // stepKey: uploadFileAddImageToConfigurableProductOptionTwoWaitForPageLoad
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageToConfigurableProductOptionTwo
		$I->waitForElementVisible("//*[@data-role='gallery']//img[contains(@src, 'magento3')]", 30); // stepKey: waitForThumbnailAddImageToConfigurableProductOptionTwo
		$I->comment("Exiting Action Group [addImageToConfigurableProductOptionTwo] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->comment("Entering Action Group [saveProductForm] GenerateAndSaveConfiguredProductAfterSettingOptionsActionGroup");
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButtonSaveProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonSaveProductFormWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnGenerateProductsButtonSaveProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnGenerateProductsButtonSaveProductFormWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButton2SaveProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButton2SaveProductFormWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmInPopupSaveProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupSaveProductFormWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessageSaveProductForm
		$I->comment("Exiting Action Group [saveProductForm] GenerateAndSaveConfiguredProductAfterSettingOptionsActionGroup");
		$I->comment("Go to the category page");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage
		$I->comment("Entering Action Group [StorefrontAssertActiveProductImage] StorefrontAssertActiveProductImageActionGroup");
		$I->seeElement(".product.media div[data-active=true] > img[src*='magento-logo']"); // stepKey: seeActiveImageDefaultStorefrontAssertActiveProductImage
		$I->comment("Exiting Action Group [StorefrontAssertActiveProductImage] StorefrontAssertActiveProductImageActionGroup");
		$I->comment("Click a swatch and expect to see the image from the swatch from the configurable product");
		$I->comment("Entering Action Group [clickSwatchOption] StorefrontSelectSwatchOptionOnProductPageAndCheckImageActionGroup");
		$I->click("div.swatch-option[data-option-label='VisualOpt1" . msq("visualSwatchOption1") . "']"); // stepKey: clickSwatchOptionClickSwatchOption
		$I->seeElement(".product.media div[data-active=true] > img[src*='adobe-base']"); // stepKey: seeActiveImageDefaultClickSwatchOption
		$I->comment("Exiting Action Group [clickSwatchOption] StorefrontSelectSwatchOptionOnProductPageAndCheckImageActionGroup");
		$I->comment("Entering Action Group [seeFirstImageBaseProductInSwatchOption] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->seeElement(".fotorama__nav__shaft img[src*='magento-logo']"); // stepKey: seeActiveImageDefaultSeeFirstImageBaseProductInSwatchOption
		$I->waitForPageLoad(30); // stepKey: seeActiveImageDefaultSeeFirstImageBaseProductInSwatchOptionWaitForPageLoad
		$I->comment("Exiting Action Group [seeFirstImageBaseProductInSwatchOption] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->comment("Entering Action Group [seeSecondImageBaseProductInSwatchOption] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->seeElement(".fotorama__nav__shaft img[src*='magento-again']"); // stepKey: seeActiveImageDefaultSeeSecondImageBaseProductInSwatchOption
		$I->waitForPageLoad(30); // stepKey: seeActiveImageDefaultSeeSecondImageBaseProductInSwatchOptionWaitForPageLoad
		$I->comment("Exiting Action Group [seeSecondImageBaseProductInSwatchOption] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->comment("Entering Action Group [clickOnSwatchOption2] StorefrontSelectSwatchOptionOnProductPageAndCheckImageActionGroup");
		$I->click("div.swatch-option[data-option-label='VisualOpt2" . msq("visualSwatchOption2") . "']"); // stepKey: clickSwatchOptionClickOnSwatchOption2
		$I->seeElement(".product.media div[data-active=true] > img[src*='magento3']"); // stepKey: seeActiveImageDefaultClickOnSwatchOption2
		$I->comment("Exiting Action Group [clickOnSwatchOption2] StorefrontSelectSwatchOptionOnProductPageAndCheckImageActionGroup");
		$I->comment("Entering Action Group [seeFirstImageBaseProductInSwatchOption2] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->seeElement(".fotorama__nav__shaft img[src*='magento-logo']"); // stepKey: seeActiveImageDefaultSeeFirstImageBaseProductInSwatchOption2
		$I->waitForPageLoad(30); // stepKey: seeActiveImageDefaultSeeFirstImageBaseProductInSwatchOption2WaitForPageLoad
		$I->comment("Exiting Action Group [seeFirstImageBaseProductInSwatchOption2] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->comment("Entering Action Group [seeSecondImageBaseProductInSwatchOption2] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->seeElement(".fotorama__nav__shaft img[src*='magento-again']"); // stepKey: seeActiveImageDefaultSeeSecondImageBaseProductInSwatchOption2
		$I->waitForPageLoad(30); // stepKey: seeActiveImageDefaultSeeSecondImageBaseProductInSwatchOption2WaitForPageLoad
		$I->comment("Exiting Action Group [seeSecondImageBaseProductInSwatchOption2] StorefrontAssertFotoramaImageAvailabilityActionGroup");
	}
}
