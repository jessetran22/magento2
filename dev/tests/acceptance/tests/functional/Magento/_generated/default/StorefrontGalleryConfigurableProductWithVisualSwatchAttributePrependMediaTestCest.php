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
 * @Title("MC-26184: Storefront Gallery - Configurable Product with Visual Swatch: prepend variation media")
 * @Description("Verify functionality of updating Gallery items on 'view Product' Storefront page for Configurable Product with Visual Swatch input type attribute. Verify that Configurable Product media in Gallery is prepended with media from selected variation<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/StorefrontGalleryConfigurableProductWithVisualSwatchAttributePrependMediaTest.xml<br>")
 * @TestCaseId("MC-26184")
 * @group catalog
 * @group configurableProduct
 * @group swatch
 */
class StorefrontGalleryConfigurableProductWithVisualSwatchAttributePrependMediaTestCest
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
		$I->comment("Create 1 configurable product");
		$I->createEntity("createConfigurableProduct", "hook", "ApiConfigurableProductWithDescription", [], []); // stepKey: createConfigurableProduct
		$I->comment("Create product swatch attribute with 2 variations");
		$I->createEntity("createVisualSwatchAttribute", "hook", "VisualSwatchProductAttributeForm", [], []); // stepKey: createVisualSwatchAttribute
		$I->createEntity("swatchAttributeFirstOption", "hook", "SwatchProductAttributeOption1", ["createVisualSwatchAttribute"], []); // stepKey: swatchAttributeFirstOption
		$I->createEntity("swatchAttributeSecondOption", "hook", "SwatchProductAttributeOption2", ["createVisualSwatchAttribute"], []); // stepKey: swatchAttributeSecondOption
		$I->createEntity("swatchAttributeThirdOption", "hook", "SwatchProductAttributeOption3", ["createVisualSwatchAttribute"], []); // stepKey: swatchAttributeThirdOption
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Open configurable product edit page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigurableProduct', 'id', 'hook')); // stepKey: goToProductIndex
		$I->comment("Add attribute to configurable product");
		$I->conditionalClick(".admin__collapsible-block-wrapper[data-index='configurable']", "button[data-index='create_configurable_products_button']", false); // stepKey: openConfigurationSection
		$I->waitForPageLoad(30); // stepKey: openConfigurationSectionWaitForPageLoad
		$I->comment("Entering Action Group [createProductConfigurations] GenerateConfigurationsByAttributeCodeActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurationsCreateProductConfigurations
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsCreateProductConfigurationsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersCreateProductConfigurations
		$I->fillField(".admin__control-text[name='attribute_code']", $I->retrieveEntityField('createVisualSwatchAttribute', 'attribute_code', 'hook')); // stepKey: fillFilterAttributeCodeFieldCreateProductConfigurations
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonCreateProductConfigurations
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonCreateProductConfigurationsWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxCreateProductConfigurations
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1CreateProductConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1CreateProductConfigurationsWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllCreateProductConfigurations
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2CreateProductConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2CreateProductConfigurationsWaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuCreateProductConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuCreateProductConfigurationsWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "99"); // stepKey: enterAttributeQuantityCreateProductConfigurations
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3CreateProductConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3CreateProductConfigurationsWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4CreateProductConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4CreateProductConfigurationsWaitForPageLoad
		$I->comment("Exiting Action Group [createProductConfigurations] GenerateConfigurationsByAttributeCodeActionGroup");
		$I->comment("Load media for configurable product");
		$I->comment("Entering Action Group [addFirstImageToConfigurableProduct] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddFirstImageToConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddFirstImageToConfigurableProduct
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddFirstImageToConfigurableProduct
		$I->attachFile("#fileupload", "magento2.jpg"); // stepKey: uploadFileAddFirstImageToConfigurableProduct
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddFirstImageToConfigurableProduct
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento2')]", 30); // stepKey: waitForThumbnailAddFirstImageToConfigurableProduct
		$I->comment("Exiting Action Group [addFirstImageToConfigurableProduct] AddProductImageActionGroup");
		$I->comment("Entering Action Group [addSecondImageToConfigurableProduct] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddSecondImageToConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddSecondImageToConfigurableProduct
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddSecondImageToConfigurableProduct
		$I->attachFile("#fileupload", "magento3.jpg"); // stepKey: uploadFileAddSecondImageToConfigurableProduct
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddSecondImageToConfigurableProduct
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento3')]", 30); // stepKey: waitForThumbnailAddSecondImageToConfigurableProduct
		$I->comment("Exiting Action Group [addSecondImageToConfigurableProduct] AddProductImageActionGroup");
		$I->comment("Entering Action Group [addVideoToConfigurableProduct] AdminAddProductVideoWithPreviewActionGroup");
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title", 0, -100); // stepKey: scrollToAreaAddVideoToConfigurableProduct
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductVideoSectionAddVideoToConfigurableProduct
		$I->waitForElementVisible("#add_video_button", 30); // stepKey: waitForAddVideoButtonVisibleAddVideoToConfigurableProduct
		$I->waitForPageLoad(60); // stepKey: waitForAddVideoButtonVisibleAddVideoToConfigurableProductWaitForPageLoad
		$I->click("#add_video_button"); // stepKey: addVideoAddVideoToConfigurableProduct
		$I->waitForPageLoad(60); // stepKey: addVideoAddVideoToConfigurableProductWaitForPageLoad
		$I->waitForElementVisible(".modal-slide.mage-new-video-dialog.form-inline._show", 30); // stepKey: waitForUrlElementVisibleslideAddVideoToConfigurableProduct
		$I->waitForElementVisible("#video_url", 60); // stepKey: waitForUrlElementVisibleAddVideoToConfigurableProduct
		$I->fillField("#video_url", "https://vimeo.com/76979871"); // stepKey: fillFieldVideoUrlAddVideoToConfigurableProduct
		$I->fillField("#video_title", "The New Vimeo Player (You Know, For Videos)"); // stepKey: fillFieldVideoTitleAddVideoToConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddVideoToConfigurableProduct
		$I->waitForElementNotVisible("//button[@class='action-primary video-create-button' and @disabled='disabled']", 30); // stepKey: waitForSaveButtonVisibleAddVideoToConfigurableProduct
		$I->attachFile(".field-new_video_screenshot #new_video_screenshot", "magento-again.jpg"); // stepKey: addPreviewImageAddVideoToConfigurableProduct
		$I->click(".action-primary.video-create-button"); // stepKey: saveVideoAddVideoToConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: saveVideoAddVideoToConfigurableProductWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearAddVideoToConfigurableProduct
		$I->comment("Exiting Action Group [addVideoToConfigurableProduct] AdminAddProductVideoWithPreviewActionGroup");
		$I->comment("Entering Action Group [assertVideoAddedToConfigurableProduct] AssertProductVideoAdminProductPageActionGroup");
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title", 0, -100); // stepKey: scrollToAreaAssertVideoAddedToConfigurableProduct
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductVideoSectionAssertVideoAddedToConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertVideoAddedToConfigurableProduct
		$I->seeElement("//*[@id='media_gallery_content']//div[contains(text(), 'The New Vimeo Player')]"); // stepKey: seeVideoTitleAssertVideoAddedToConfigurableProduct
		$I->seeElementInDOM("//*[@id='media_gallery_content']//input[@value='https://vimeo.com/76979871']"); // stepKey: seeVideoItemAssertVideoAddedToConfigurableProduct
		$I->comment("Exiting Action Group [assertVideoAddedToConfigurableProduct] AssertProductVideoAdminProductPageActionGroup");
		$I->comment("Entering Action Group [saveConfigurableProduct] SaveConfigurableProductAddToCurrentAttributeSetActionGroup");
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveBtnVisibleSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveBtnVisibleSaveConfigurableProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: saveProductAgainSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: saveProductAgainSaveConfigurableProductWaitForPageLoad
		$I->waitForElementVisible("button[data-index='confirm_button']", 30); // stepKey: waitPopUpVisibleSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitPopUpVisibleSaveConfigurableProductWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmPopupSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmPopupSaveConfigurableProductWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSaveProductMessageSaveConfigurableProduct
		$I->comment("Exiting Action Group [saveConfigurableProduct] SaveConfigurableProductAddToCurrentAttributeSetActionGroup");
		$I->comment("Load media for configurable product variation option1");
		$I->comment("Entering Action Group [openConfigurableProductVariationOption1] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageOpenConfigurableProductVariationOption1
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadOpenConfigurableProductVariationOption1
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersOpenConfigurableProductVariationOption1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersOpenConfigurableProductVariationOption1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersOpenConfigurableProductVariationOption1
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigurableProduct', 'sku', 'hook') . "-" . $I->retrieveEntityField('swatchAttributeFirstOption', 'option[store_labels][0][label]', 'hook')); // stepKey: fillProductSkuFilterOpenConfigurableProductVariationOption1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersOpenConfigurableProductVariationOption1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersOpenConfigurableProductVariationOption1WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadOpenConfigurableProductVariationOption1
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createConfigurableProduct', 'sku', 'hook') . "-" . $I->retrieveEntityField('swatchAttributeFirstOption', 'option[store_labels][0][label]', 'hook') . "']]"); // stepKey: openSelectedProductOpenConfigurableProductVariationOption1
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadOpenConfigurableProductVariationOption1
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleOpenConfigurableProductVariationOption1
		$I->comment("Exiting Action Group [openConfigurableProductVariationOption1] FilterAndSelectProductActionGroup");
		$I->comment("Entering Action Group [addFirstImageToConfigurableProductVariationOption1] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddFirstImageToConfigurableProductVariationOption1
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddFirstImageToConfigurableProductVariationOption1
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddFirstImageToConfigurableProductVariationOption1
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileAddFirstImageToConfigurableProductVariationOption1
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddFirstImageToConfigurableProductVariationOption1
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddFirstImageToConfigurableProductVariationOption1
		$I->comment("Exiting Action Group [addFirstImageToConfigurableProductVariationOption1] AddProductImageActionGroup");
		$I->comment("Entering Action Group [addSecondImageToConfigurableProductVariationOption1] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddSecondImageToConfigurableProductVariationOption1
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddSecondImageToConfigurableProductVariationOption1
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddSecondImageToConfigurableProductVariationOption1
		$I->attachFile("#fileupload", "magento-again.jpg"); // stepKey: uploadFileAddSecondImageToConfigurableProductVariationOption1
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddSecondImageToConfigurableProductVariationOption1
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]", 30); // stepKey: waitForThumbnailAddSecondImageToConfigurableProductVariationOption1
		$I->comment("Exiting Action Group [addSecondImageToConfigurableProductVariationOption1] AddProductImageActionGroup");
		$I->comment("Entering Action Group [addVideoToConfigurableProductVariationOption1] AdminAddProductVideoWithPreviewActionGroup");
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title", 0, -100); // stepKey: scrollToAreaAddVideoToConfigurableProductVariationOption1
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductVideoSectionAddVideoToConfigurableProductVariationOption1
		$I->waitForElementVisible("#add_video_button", 30); // stepKey: waitForAddVideoButtonVisibleAddVideoToConfigurableProductVariationOption1
		$I->waitForPageLoad(60); // stepKey: waitForAddVideoButtonVisibleAddVideoToConfigurableProductVariationOption1WaitForPageLoad
		$I->click("#add_video_button"); // stepKey: addVideoAddVideoToConfigurableProductVariationOption1
		$I->waitForPageLoad(60); // stepKey: addVideoAddVideoToConfigurableProductVariationOption1WaitForPageLoad
		$I->waitForElementVisible(".modal-slide.mage-new-video-dialog.form-inline._show", 30); // stepKey: waitForUrlElementVisibleslideAddVideoToConfigurableProductVariationOption1
		$I->waitForElementVisible("#video_url", 60); // stepKey: waitForUrlElementVisibleAddVideoToConfigurableProductVariationOption1
		$I->fillField("#video_url", "https://vimeo.com/76979871"); // stepKey: fillFieldVideoUrlAddVideoToConfigurableProductVariationOption1
		$I->fillField("#video_title", "The New Vimeo Player (You Know, For Videos)"); // stepKey: fillFieldVideoTitleAddVideoToConfigurableProductVariationOption1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddVideoToConfigurableProductVariationOption1
		$I->waitForElementNotVisible("//button[@class='action-primary video-create-button' and @disabled='disabled']", 30); // stepKey: waitForSaveButtonVisibleAddVideoToConfigurableProductVariationOption1
		$I->attachFile(".field-new_video_screenshot #new_video_screenshot", "adobe-small.jpg"); // stepKey: addPreviewImageAddVideoToConfigurableProductVariationOption1
		$I->click(".action-primary.video-create-button"); // stepKey: saveVideoAddVideoToConfigurableProductVariationOption1
		$I->waitForPageLoad(30); // stepKey: saveVideoAddVideoToConfigurableProductVariationOption1WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearAddVideoToConfigurableProductVariationOption1
		$I->comment("Exiting Action Group [addVideoToConfigurableProductVariationOption1] AdminAddProductVideoWithPreviewActionGroup");
		$I->comment("Entering Action Group [assertVideoAddedToConfigurableProductVariationOption1] AssertProductVideoAdminProductPageActionGroup");
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title", 0, -100); // stepKey: scrollToAreaAssertVideoAddedToConfigurableProductVariationOption1
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductVideoSectionAssertVideoAddedToConfigurableProductVariationOption1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertVideoAddedToConfigurableProductVariationOption1
		$I->seeElement("//*[@id='media_gallery_content']//div[contains(text(), 'The New Vimeo Player')]"); // stepKey: seeVideoTitleAssertVideoAddedToConfigurableProductVariationOption1
		$I->seeElementInDOM("//*[@id='media_gallery_content']//input[@value='https://vimeo.com/76979871']"); // stepKey: seeVideoItemAssertVideoAddedToConfigurableProductVariationOption1
		$I->comment("Exiting Action Group [assertVideoAddedToConfigurableProductVariationOption1] AssertProductVideoAdminProductPageActionGroup");
		$I->comment("Entering Action Group [saveConfigurableProductVariationOption1] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveConfigurableProductVariationOption1
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveConfigurableProductVariationOption1
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveConfigurableProductVariationOption1WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveConfigurableProductVariationOption1
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveConfigurableProductVariationOption1WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveConfigurableProductVariationOption1
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveConfigurableProductVariationOption1
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveConfigurableProductVariationOption1
		$I->comment("Exiting Action Group [saveConfigurableProductVariationOption1] SaveProductFormActionGroup");
		$I->comment("Load media for configurable product variation option3");
		$I->comment("Entering Action Group [openConfigurableProductVariationOption3] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageOpenConfigurableProductVariationOption3
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadOpenConfigurableProductVariationOption3
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersOpenConfigurableProductVariationOption3
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersOpenConfigurableProductVariationOption3WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersOpenConfigurableProductVariationOption3
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigurableProduct', 'sku', 'hook') . "-" . $I->retrieveEntityField('swatchAttributeThirdOption', 'option[store_labels][0][label]', 'hook')); // stepKey: fillProductSkuFilterOpenConfigurableProductVariationOption3
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersOpenConfigurableProductVariationOption3
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersOpenConfigurableProductVariationOption3WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadOpenConfigurableProductVariationOption3
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createConfigurableProduct', 'sku', 'hook') . "-" . $I->retrieveEntityField('swatchAttributeThirdOption', 'option[store_labels][0][label]', 'hook') . "']]"); // stepKey: openSelectedProductOpenConfigurableProductVariationOption3
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadOpenConfigurableProductVariationOption3
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleOpenConfigurableProductVariationOption3
		$I->comment("Exiting Action Group [openConfigurableProductVariationOption3] FilterAndSelectProductActionGroup");
		$I->comment("Entering Action Group [addVideoToConfigurableProductVariationOption3] AdminAddProductVideoWithPreviewActionGroup");
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title", 0, -100); // stepKey: scrollToAreaAddVideoToConfigurableProductVariationOption3
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductVideoSectionAddVideoToConfigurableProductVariationOption3
		$I->waitForElementVisible("#add_video_button", 30); // stepKey: waitForAddVideoButtonVisibleAddVideoToConfigurableProductVariationOption3
		$I->waitForPageLoad(60); // stepKey: waitForAddVideoButtonVisibleAddVideoToConfigurableProductVariationOption3WaitForPageLoad
		$I->click("#add_video_button"); // stepKey: addVideoAddVideoToConfigurableProductVariationOption3
		$I->waitForPageLoad(60); // stepKey: addVideoAddVideoToConfigurableProductVariationOption3WaitForPageLoad
		$I->waitForElementVisible(".modal-slide.mage-new-video-dialog.form-inline._show", 30); // stepKey: waitForUrlElementVisibleslideAddVideoToConfigurableProductVariationOption3
		$I->waitForElementVisible("#video_url", 60); // stepKey: waitForUrlElementVisibleAddVideoToConfigurableProductVariationOption3
		$I->fillField("#video_url", "https://vimeo.com/76979871"); // stepKey: fillFieldVideoUrlAddVideoToConfigurableProductVariationOption3
		$I->fillField("#video_title", "The New Vimeo Player (You Know, For Videos)"); // stepKey: fillFieldVideoTitleAddVideoToConfigurableProductVariationOption3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddVideoToConfigurableProductVariationOption3
		$I->waitForElementNotVisible("//button[@class='action-primary video-create-button' and @disabled='disabled']", 30); // stepKey: waitForSaveButtonVisibleAddVideoToConfigurableProductVariationOption3
		$I->attachFile(".field-new_video_screenshot #new_video_screenshot", "magento3.jpg"); // stepKey: addPreviewImageAddVideoToConfigurableProductVariationOption3
		$I->click(".action-primary.video-create-button"); // stepKey: saveVideoAddVideoToConfigurableProductVariationOption3
		$I->waitForPageLoad(30); // stepKey: saveVideoAddVideoToConfigurableProductVariationOption3WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearAddVideoToConfigurableProductVariationOption3
		$I->comment("Exiting Action Group [addVideoToConfigurableProductVariationOption3] AdminAddProductVideoWithPreviewActionGroup");
		$I->comment("Entering Action Group [assertVideoAddedToConfigurableProductVariationOption3] AssertProductVideoAdminProductPageActionGroup");
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title", 0, -100); // stepKey: scrollToAreaAssertVideoAddedToConfigurableProductVariationOption3
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductVideoSectionAssertVideoAddedToConfigurableProductVariationOption3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertVideoAddedToConfigurableProductVariationOption3
		$I->seeElement("//*[@id='media_gallery_content']//div[contains(text(), 'The New Vimeo Player')]"); // stepKey: seeVideoTitleAssertVideoAddedToConfigurableProductVariationOption3
		$I->seeElementInDOM("//*[@id='media_gallery_content']//input[@value='https://vimeo.com/76979871']"); // stepKey: seeVideoItemAssertVideoAddedToConfigurableProductVariationOption3
		$I->comment("Exiting Action Group [assertVideoAddedToConfigurableProductVariationOption3] AssertProductVideoAdminProductPageActionGroup");
		$I->comment("Entering Action Group [addSecondImageToConfigurableProductVariationOption3] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddSecondImageToConfigurableProductVariationOption3
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddSecondImageToConfigurableProductVariationOption3
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddSecondImageToConfigurableProductVariationOption3
		$I->attachFile("#fileupload", "adobe-base.jpg"); // stepKey: uploadFileAddSecondImageToConfigurableProductVariationOption3
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddSecondImageToConfigurableProductVariationOption3
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", 30); // stepKey: waitForThumbnailAddSecondImageToConfigurableProductVariationOption3
		$I->comment("Exiting Action Group [addSecondImageToConfigurableProductVariationOption3] AddProductImageActionGroup");
		$I->comment("Entering Action Group [addSecondVideoToConfigurableProductVariationOption3] AdminAddProductVideoWithPreviewActionGroup");
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title", 0, -100); // stepKey: scrollToAreaAddSecondVideoToConfigurableProductVariationOption3
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductVideoSectionAddSecondVideoToConfigurableProductVariationOption3
		$I->waitForElementVisible("#add_video_button", 30); // stepKey: waitForAddVideoButtonVisibleAddSecondVideoToConfigurableProductVariationOption3
		$I->waitForPageLoad(60); // stepKey: waitForAddVideoButtonVisibleAddSecondVideoToConfigurableProductVariationOption3WaitForPageLoad
		$I->click("#add_video_button"); // stepKey: addVideoAddSecondVideoToConfigurableProductVariationOption3
		$I->waitForPageLoad(60); // stepKey: addVideoAddSecondVideoToConfigurableProductVariationOption3WaitForPageLoad
		$I->waitForElementVisible(".modal-slide.mage-new-video-dialog.form-inline._show", 30); // stepKey: waitForUrlElementVisibleslideAddSecondVideoToConfigurableProductVariationOption3
		$I->waitForElementVisible("#video_url", 60); // stepKey: waitForUrlElementVisibleAddSecondVideoToConfigurableProductVariationOption3
		$I->fillField("#video_url", "https://vimeo.com/76979871"); // stepKey: fillFieldVideoUrlAddSecondVideoToConfigurableProductVariationOption3
		$I->fillField("#video_title", "The New Vimeo Player (You Know, For Videos)"); // stepKey: fillFieldVideoTitleAddSecondVideoToConfigurableProductVariationOption3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSecondVideoToConfigurableProductVariationOption3
		$I->waitForElementNotVisible("//button[@class='action-primary video-create-button' and @disabled='disabled']", 30); // stepKey: waitForSaveButtonVisibleAddSecondVideoToConfigurableProductVariationOption3
		$I->attachFile(".field-new_video_screenshot #new_video_screenshot", "magento-logo.png"); // stepKey: addPreviewImageAddSecondVideoToConfigurableProductVariationOption3
		$I->click(".action-primary.video-create-button"); // stepKey: saveVideoAddSecondVideoToConfigurableProductVariationOption3
		$I->waitForPageLoad(30); // stepKey: saveVideoAddSecondVideoToConfigurableProductVariationOption3WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearAddSecondVideoToConfigurableProductVariationOption3
		$I->comment("Exiting Action Group [addSecondVideoToConfigurableProductVariationOption3] AdminAddProductVideoWithPreviewActionGroup");
		$I->comment("Entering Action Group [assertSecondVideoAddedToConfigurableProductVariationOption3] AssertProductVideoAdminProductPageActionGroup");
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title", 0, -100); // stepKey: scrollToAreaAssertSecondVideoAddedToConfigurableProductVariationOption3
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductVideoSectionAssertSecondVideoAddedToConfigurableProductVariationOption3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertSecondVideoAddedToConfigurableProductVariationOption3
		$I->seeElement("//*[@id='media_gallery_content']//div[contains(text(), 'The New Vimeo Player')]"); // stepKey: seeVideoTitleAssertSecondVideoAddedToConfigurableProductVariationOption3
		$I->seeElementInDOM("//*[@id='media_gallery_content']//input[@value='https://vimeo.com/76979871']"); // stepKey: seeVideoItemAssertSecondVideoAddedToConfigurableProductVariationOption3
		$I->comment("Exiting Action Group [assertSecondVideoAddedToConfigurableProductVariationOption3] AssertProductVideoAdminProductPageActionGroup");
		$I->comment("Entering Action Group [saveConfigurableProductVariationOption3] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveConfigurableProductVariationOption3
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveConfigurableProductVariationOption3
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveConfigurableProductVariationOption3WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveConfigurableProductVariationOption3
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveConfigurableProductVariationOption3WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveConfigurableProductVariationOption3
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveConfigurableProductVariationOption3
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveConfigurableProductVariationOption3
		$I->comment("Exiting Action Group [saveConfigurableProductVariationOption3] SaveProductFormActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created");
		$reindexInvalidatedIndicesAfterCreateAttributes = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndicesAfterCreateAttributes
		$I->comment($reindexInvalidatedIndicesAfterCreateAttributes);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteConfigurableProductsWithAllVariations] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteConfigurableProductsWithAllVariations
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteConfigurableProductsWithAllVariations
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteConfigurableProductsWithAllVariations
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteConfigurableProductsWithAllVariationsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteConfigurableProductsWithAllVariations
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigurableProduct', 'sku', 'hook')); // stepKey: fillProductSkuFilterDeleteConfigurableProductsWithAllVariations
		$I->fillField("input.admin__control-text[name='name']", $I->retrieveEntityField('createConfigurableProduct', 'name', 'hook')); // stepKey: fillProductNameFilterDeleteConfigurableProductsWithAllVariations
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteConfigurableProductsWithAllVariations
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteConfigurableProductsWithAllVariationsWaitForPageLoad
		$I->see($I->retrieveEntityField('createConfigurableProduct', 'sku', 'hook'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteConfigurableProductsWithAllVariations
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteConfigurableProductsWithAllVariations
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteConfigurableProductsWithAllVariations
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteConfigurableProductsWithAllVariations
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteConfigurableProductsWithAllVariationsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteConfigurableProductsWithAllVariations
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteConfigurableProductsWithAllVariationsWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteConfigurableProductsWithAllVariations
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteConfigurableProductsWithAllVariations
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteConfigurableProductsWithAllVariationsWaitForPageLoad
		$I->comment("Exiting Action Group [deleteConfigurableProductsWithAllVariations] DeleteProductUsingProductGridActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForDeleteSuccessMessage
		$I->see("A total of 4 record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeDeleteSuccessMessage
		$I->comment("Entering Action Group [clearProductGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearProductGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearProductGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [deleteProductVisualSwatchAttribute] DeleteProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteProductVisualSwatchAttribute
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteProductVisualSwatchAttribute
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteProductVisualSwatchAttributeWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", $I->retrieveEntityField('createVisualSwatchAttribute', 'attribute_code', 'hook')); // stepKey: setAttributeCodeDeleteProductVisualSwatchAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridDeleteProductVisualSwatchAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridDeleteProductVisualSwatchAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteProductVisualSwatchAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteProductVisualSwatchAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2DeleteProductVisualSwatchAttribute
		$I->click("#delete"); // stepKey: deleteAttributeDeleteProductVisualSwatchAttribute
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteProductVisualSwatchAttributeWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: ClickOnDeleteButtonDeleteProductVisualSwatchAttribute
		$I->waitForPageLoad(30); // stepKey: ClickOnDeleteButtonDeleteProductVisualSwatchAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteProductVisualSwatchAttribute
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessageDeleteProductVisualSwatchAttribute
		$I->comment("Exiting Action Group [deleteProductVisualSwatchAttribute] DeleteProductAttributeActionGroup");
		$I->comment("Entering Action Group [clearProductAttributeGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearProductAttributeGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearProductAttributeGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductAttributeGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created");
		$reindexInvalidatedIndicesAfterDeleteAttributes = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndicesAfterDeleteAttributes
		$I->comment($reindexInvalidatedIndicesAfterDeleteAttributes);
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
	 * @Features({"ConfigurableProduct"})
	 * @Stories({"Prepend variation media on storefront"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontGalleryConfigurableProductWithVisualSwatchAttributePrependMediaTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openConfigurableProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigurableProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenConfigurableProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenConfigurableProductPage
		$I->comment("Exiting Action Group [openConfigurableProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("CASE 0: Selected options = none; Expected media : C1, C2, C3");
		$I->waitForElementVisible(".fotorama__nav__shaft img", 30); // stepKey: waitForThumbnailsAppearCase0
		$getListOfThumbnailsCase0 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsCase0
		$I->assertRegExp("|magento2.*.jpg|", $getListOfThumbnailsCase0[0]); // stepKey: checkPositionInThumbnailForImage1Case0
		$I->assertRegExp("|magento3.*.jpg|", $getListOfThumbnailsCase0[1]); // stepKey: checkPositionInThumbnailForImage2Case0
		$I->assertRegExp("|magento-again.*.jpg|", $getListOfThumbnailsCase0[2]); // stepKey: checkPositionInThumbnailForImage3Case0
		$I->comment("Entering Action Group [seeImageOnPreviewCase0] AssertStorefrontProductImageAppearsOnProductPagePreviewActionGroup");
		$I->waitForElementNotVisible("#maincontent .fotorama__spinner--show", 30); // stepKey: waitGallerySpinnerDisappearSeeImageOnPreviewCase0
		$I->seeElement("[data-gallery-role='gallery']"); // stepKey: seeProductGallerySeeImageOnPreviewCase0
		$I->waitForPageLoad(30); // stepKey: seeProductGallerySeeImageOnPreviewCase0WaitForPageLoad
		$I->seeElement(".product.media div[data-active=true] > img[src*='magento2']"); // stepKey: seeCorrectProductImageSeeImageOnPreviewCase0
		$I->comment("Exiting Action Group [seeImageOnPreviewCase0] AssertStorefrontProductImageAppearsOnProductPagePreviewActionGroup");
		$I->comment("Entering Action Group [openFullScreenPageCase0] StorefrontProductPageOpenImageFullscreenActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", 30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase0
		$I->waitForPageLoad(30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase0WaitForPageLoad
		$I->conditionalClick("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", "//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb') and contains(@class, 'fotorama__active')][2]", false); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase0
		$I->waitForPageLoad(30); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase0WaitForPageLoad
		$I->click("[data-gallery-role='gallery']"); // stepKey: openFullScreenPageOpenFullScreenPageCase0
		$I->waitForPageLoad(30); // stepKey: openFullScreenPageOpenFullScreenPageCase0WaitForPageLoad
		$I->comment("Exiting Action Group [openFullScreenPageCase0] StorefrontProductPageOpenImageFullscreenActionGroup");
		$getListOfThumbnailsFullScreenPageCase0 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsFullScreenPageCase0
		$I->assertEquals($getListOfThumbnailsCase0, $getListOfThumbnailsFullScreenPageCase0); // stepKey: checkPositionInThumbnailForImagesFromFullScreenPageCase0
		$I->comment("Entering Action Group [closeFullScreenPageCase0] StorefrontProductPageCloseFullscreenGalleryActionGroup");
		$I->click("//*[@data-gallery-role='gallery' and contains(@class, 'fullscreen')]//*[@data-gallery-role='fotorama__fullscreen-icon']"); // stepKey: closeFullScreenPageCloseFullScreenPageCase0
		$I->waitForPageLoad(30); // stepKey: waitsForCloseFullScreenPageCloseFullScreenPageCase0
		$I->comment("Exiting Action Group [closeFullScreenPageCase0] StorefrontProductPageCloseFullscreenGalleryActionGroup");
		$I->comment("CASE 1: Selected options = B1; Expected media : D1, D2, D3, C1, C2, C3");
		$I->click("div.swatch-option[data-option-label='" . $I->retrieveEntityField('swatchAttributeFirstOption', 'option[store_labels][0][label]', 'test') . "']"); // stepKey: chooseFirstOptionCase1
		$I->waitForElementVisible(".fotorama__nav__shaft img", 30); // stepKey: waitForThumbnailsAppearCase1
		$getListOfThumbnailsCase1 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsCase1
		$I->assertRegExp("|magento-logo.*.png|", $getListOfThumbnailsCase1[0]); // stepKey: checkPositionInThumbnailForImage1Case1
		$I->assertRegExp("|magento-again.*.jpg|", $getListOfThumbnailsCase1[1]); // stepKey: checkPositionInThumbnailForImage2Case1
		$I->assertRegExp("|adobe-small.*.jpg|", $getListOfThumbnailsCase1[2]); // stepKey: checkPositionInThumbnailForImage3Case1
		$I->assertRegExp("|magento2.*.jpg|", $getListOfThumbnailsCase1[3]); // stepKey: checkPositionInThumbnailForImage4Case1
		$I->assertRegExp("|magento3.*.jpg|", $getListOfThumbnailsCase1[4]); // stepKey: checkPositionInThumbnailForImage5Case1
		$I->assertRegExp("|magento-again.*.jpg|", $getListOfThumbnailsCase1[5]); // stepKey: checkPositionInThumbnailForImage6Case1
		$I->comment("Entering Action Group [seeImageOnPreviewCase1] AssertStorefrontProductImageAppearsOnProductPagePreviewActionGroup");
		$I->waitForElementNotVisible("#maincontent .fotorama__spinner--show", 30); // stepKey: waitGallerySpinnerDisappearSeeImageOnPreviewCase1
		$I->seeElement("[data-gallery-role='gallery']"); // stepKey: seeProductGallerySeeImageOnPreviewCase1
		$I->waitForPageLoad(30); // stepKey: seeProductGallerySeeImageOnPreviewCase1WaitForPageLoad
		$I->seeElement(".product.media div[data-active=true] > img[src*='magento-logo']"); // stepKey: seeCorrectProductImageSeeImageOnPreviewCase1
		$I->comment("Exiting Action Group [seeImageOnPreviewCase1] AssertStorefrontProductImageAppearsOnProductPagePreviewActionGroup");
		$I->comment("Entering Action Group [openFullScreenPageCase1] StorefrontProductPageOpenImageFullscreenActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", 30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase1
		$I->waitForPageLoad(30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase1WaitForPageLoad
		$I->conditionalClick("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", "//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb') and contains(@class, 'fotorama__active')][2]", false); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase1
		$I->waitForPageLoad(30); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase1WaitForPageLoad
		$I->click("[data-gallery-role='gallery']"); // stepKey: openFullScreenPageOpenFullScreenPageCase1
		$I->waitForPageLoad(30); // stepKey: openFullScreenPageOpenFullScreenPageCase1WaitForPageLoad
		$I->comment("Exiting Action Group [openFullScreenPageCase1] StorefrontProductPageOpenImageFullscreenActionGroup");
		$getListOfThumbnailsFullScreenPageCase1 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsFullScreenPageCase1
		$I->assertEquals($getListOfThumbnailsCase1, $getListOfThumbnailsFullScreenPageCase1); // stepKey: checkPositionInThumbnailForImagesFromFullScreenPageCase1
		$I->comment("Entering Action Group [closeFullScreenPageCase1] StorefrontProductPageCloseFullscreenGalleryActionGroup");
		$I->click("//*[@data-gallery-role='gallery' and contains(@class, 'fullscreen')]//*[@data-gallery-role='fotorama__fullscreen-icon']"); // stepKey: closeFullScreenPageCloseFullScreenPageCase1
		$I->waitForPageLoad(30); // stepKey: waitsForCloseFullScreenPageCloseFullScreenPageCase1
		$I->comment("Exiting Action Group [closeFullScreenPageCase1] StorefrontProductPageCloseFullscreenGalleryActionGroup");
		$I->comment("CASE 2: Selected options = B2; Expected media : C1, C2, C3");
		$I->click("div.swatch-option[data-option-label='" . $I->retrieveEntityField('swatchAttributeSecondOption', 'option[store_labels][0][label]', 'test') . "']"); // stepKey: chooseFirstOptionCase2
		$I->waitForElementVisible(".fotorama__nav__shaft img", 30); // stepKey: waitForThumbnailsAppearCase2
		$getListOfThumbnailsCase2 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsCase2
		$I->assertRegExp("|magento2.*.jpg|", $getListOfThumbnailsCase2[0]); // stepKey: checkPositionInThumbnailForImage1Case2
		$I->assertRegExp("|magento3.*.jpg|", $getListOfThumbnailsCase2[1]); // stepKey: checkPositionInThumbnailForImage2Case2
		$I->assertRegExp("|magento-again.*.jpg|", $getListOfThumbnailsCase2[2]); // stepKey: checkPositionInThumbnailForImage3Case2
		$I->comment("Entering Action Group [seeImageOnPreviewCase2] AssertStorefrontProductImageAppearsOnProductPagePreviewActionGroup");
		$I->waitForElementNotVisible("#maincontent .fotorama__spinner--show", 30); // stepKey: waitGallerySpinnerDisappearSeeImageOnPreviewCase2
		$I->seeElement("[data-gallery-role='gallery']"); // stepKey: seeProductGallerySeeImageOnPreviewCase2
		$I->waitForPageLoad(30); // stepKey: seeProductGallerySeeImageOnPreviewCase2WaitForPageLoad
		$I->seeElement(".product.media div[data-active=true] > img[src*='magento2']"); // stepKey: seeCorrectProductImageSeeImageOnPreviewCase2
		$I->comment("Exiting Action Group [seeImageOnPreviewCase2] AssertStorefrontProductImageAppearsOnProductPagePreviewActionGroup");
		$I->comment("Entering Action Group [openFullScreenPageCase2] StorefrontProductPageOpenImageFullscreenActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", 30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase2
		$I->waitForPageLoad(30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase2WaitForPageLoad
		$I->conditionalClick("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", "//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb') and contains(@class, 'fotorama__active')][2]", false); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase2
		$I->waitForPageLoad(30); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase2WaitForPageLoad
		$I->click("[data-gallery-role='gallery']"); // stepKey: openFullScreenPageOpenFullScreenPageCase2
		$I->waitForPageLoad(30); // stepKey: openFullScreenPageOpenFullScreenPageCase2WaitForPageLoad
		$I->comment("Exiting Action Group [openFullScreenPageCase2] StorefrontProductPageOpenImageFullscreenActionGroup");
		$getListOfThumbnailsFullScreenPageCase2 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsFullScreenPageCase2
		$I->assertEquals($getListOfThumbnailsCase2, $getListOfThumbnailsFullScreenPageCase2); // stepKey: checkPositionInThumbnailForImagesFromFullScreenPageCase2
		$I->comment("Entering Action Group [closeFullScreenPageCase2] StorefrontProductPageCloseFullscreenGalleryActionGroup");
		$I->click("//*[@data-gallery-role='gallery' and contains(@class, 'fullscreen')]//*[@data-gallery-role='fotorama__fullscreen-icon']"); // stepKey: closeFullScreenPageCloseFullScreenPageCase2
		$I->waitForPageLoad(30); // stepKey: waitsForCloseFullScreenPageCloseFullScreenPageCase2
		$I->comment("Exiting Action Group [closeFullScreenPageCase2] StorefrontProductPageCloseFullscreenGalleryActionGroup");
		$I->comment("CASE 3: Selected options = B3; Expected media : E1, E2, E3, C1, C2, C3");
		$I->click("div.swatch-option[data-option-label='" . $I->retrieveEntityField('swatchAttributeThirdOption', 'option[store_labels][0][label]', 'test') . "']"); // stepKey: chooseFirstOptionCase3
		$I->waitForElementVisible(".fotorama__nav__shaft img", 30); // stepKey: waitForThumbnailsAppearCase3
		$getListOfThumbnailsCase3 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsCase3
		$I->assertRegExp("|magento3.*.jpg|", $getListOfThumbnailsCase3[0]); // stepKey: checkPositionInThumbnailForImage1Case3
		$I->assertRegExp("|adobe-base.*.jpg|", $getListOfThumbnailsCase3[1]); // stepKey: checkPositionInThumbnailForImage2Case3
		$I->assertRegExp("|magento-logo.*.png|", $getListOfThumbnailsCase3[2]); // stepKey: checkPositionInThumbnailForImage3Case3
		$I->assertRegExp("|magento2.*.jpg|", $getListOfThumbnailsCase3[3]); // stepKey: checkPositionInThumbnailForImage4Case3
		$I->assertRegExp("|magento3.*.jpg|", $getListOfThumbnailsCase3[4]); // stepKey: checkPositionInThumbnailForImage5Case3
		$I->assertRegExp("|magento-again.*.jpg|", $getListOfThumbnailsCase3[5]); // stepKey: checkPositionInThumbnailForImage6Case3
		$I->comment("Entering Action Group [seeImageOnPreviewCase3] AssertStorefrontProductImageAppearsOnProductPagePreviewActionGroup");
		$I->waitForElementNotVisible("#maincontent .fotorama__spinner--show", 30); // stepKey: waitGallerySpinnerDisappearSeeImageOnPreviewCase3
		$I->seeElement("[data-gallery-role='gallery']"); // stepKey: seeProductGallerySeeImageOnPreviewCase3
		$I->waitForPageLoad(30); // stepKey: seeProductGallerySeeImageOnPreviewCase3WaitForPageLoad
		$I->seeElement(".product.media div[data-active=true] > img[src*='magento3']"); // stepKey: seeCorrectProductImageSeeImageOnPreviewCase3
		$I->comment("Exiting Action Group [seeImageOnPreviewCase3] AssertStorefrontProductImageAppearsOnProductPagePreviewActionGroup");
		$I->comment("Entering Action Group [openFullScreenPageCase3] StorefrontProductPageOpenImageFullscreenActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", 30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase3
		$I->waitForPageLoad(30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase3WaitForPageLoad
		$I->conditionalClick("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", "//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb') and contains(@class, 'fotorama__active')][2]", false); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase3
		$I->waitForPageLoad(30); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase3WaitForPageLoad
		$I->click("[data-gallery-role='gallery']"); // stepKey: openFullScreenPageOpenFullScreenPageCase3
		$I->waitForPageLoad(30); // stepKey: openFullScreenPageOpenFullScreenPageCase3WaitForPageLoad
		$I->comment("Exiting Action Group [openFullScreenPageCase3] StorefrontProductPageOpenImageFullscreenActionGroup");
		$getListOfThumbnailsFullScreenPageCase3 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsFullScreenPageCase3
		$I->assertEquals($getListOfThumbnailsCase3, $getListOfThumbnailsFullScreenPageCase3); // stepKey: checkPositionInThumbnailForImagesFromFullScreenPageCase3
		$I->comment("Entering Action Group [closeFullScreenPageCase3] StorefrontProductPageCloseFullscreenGalleryActionGroup");
		$I->click("//*[@data-gallery-role='gallery' and contains(@class, 'fullscreen')]//*[@data-gallery-role='fotorama__fullscreen-icon']"); // stepKey: closeFullScreenPageCloseFullScreenPageCase3
		$I->waitForPageLoad(30); // stepKey: waitsForCloseFullScreenPageCloseFullScreenPageCase3
		$I->comment("Exiting Action Group [closeFullScreenPageCase3] StorefrontProductPageCloseFullscreenGalleryActionGroup");
		$I->comment("CASE 4: Selected options = none; Expected media : C1, C2, C3");
		$I->click("div.swatch-option[data-option-label='" . $I->retrieveEntityField('swatchAttributeThirdOption', 'option[store_labels][0][label]', 'test') . "']"); // stepKey: unselectThirdOptionCase4
		$I->waitForElementVisible(".fotorama__nav__shaft img", 30); // stepKey: waitForThumbnailsAppearCase4
		$getListOfThumbnailsCase4 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsCase4
		$I->assertRegExp("|magento2.*.jpg|", $getListOfThumbnailsCase4[0]); // stepKey: checkPositionInThumbnailForImage1Case4
		$I->assertRegExp("|magento3.*.jpg|", $getListOfThumbnailsCase4[1]); // stepKey: checkPositionInThumbnailForImage2Case4
		$I->assertRegExp("|magento-again.*.jpg|", $getListOfThumbnailsCase4[2]); // stepKey: checkPositionInThumbnailForImage3Case4
		$I->comment("Entering Action Group [seeImageOnPreviewCase4] AssertStorefrontProductImageAppearsOnProductPagePreviewActionGroup");
		$I->waitForElementNotVisible("#maincontent .fotorama__spinner--show", 30); // stepKey: waitGallerySpinnerDisappearSeeImageOnPreviewCase4
		$I->seeElement("[data-gallery-role='gallery']"); // stepKey: seeProductGallerySeeImageOnPreviewCase4
		$I->waitForPageLoad(30); // stepKey: seeProductGallerySeeImageOnPreviewCase4WaitForPageLoad
		$I->seeElement(".product.media div[data-active=true] > img[src*='magento2']"); // stepKey: seeCorrectProductImageSeeImageOnPreviewCase4
		$I->comment("Exiting Action Group [seeImageOnPreviewCase4] AssertStorefrontProductImageAppearsOnProductPagePreviewActionGroup");
		$I->comment("Entering Action Group [openFullScreenPageCase4] StorefrontProductPageOpenImageFullscreenActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", 30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase4
		$I->waitForPageLoad(30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase4WaitForPageLoad
		$I->conditionalClick("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", "//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb') and contains(@class, 'fotorama__active')][2]", false); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase4
		$I->waitForPageLoad(30); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase4WaitForPageLoad
		$I->click("[data-gallery-role='gallery']"); // stepKey: openFullScreenPageOpenFullScreenPageCase4
		$I->waitForPageLoad(30); // stepKey: openFullScreenPageOpenFullScreenPageCase4WaitForPageLoad
		$I->comment("Exiting Action Group [openFullScreenPageCase4] StorefrontProductPageOpenImageFullscreenActionGroup");
		$getListOfThumbnailsFullScreenPageCase4 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsFullScreenPageCase4
		$I->assertEquals($getListOfThumbnailsCase4, $getListOfThumbnailsFullScreenPageCase4); // stepKey: checkPositionInThumbnailForImagesFromFullScreenPageCase4
		$I->comment("Entering Action Group [closeFullScreenPageCase4] StorefrontProductPageCloseFullscreenGalleryActionGroup");
		$I->click("//*[@data-gallery-role='gallery' and contains(@class, 'fullscreen')]//*[@data-gallery-role='fotorama__fullscreen-icon']"); // stepKey: closeFullScreenPageCloseFullScreenPageCase4
		$I->waitForPageLoad(30); // stepKey: waitsForCloseFullScreenPageCloseFullScreenPageCase4
		$I->comment("Exiting Action Group [closeFullScreenPageCase4] StorefrontProductPageCloseFullscreenGalleryActionGroup");
	}
}
