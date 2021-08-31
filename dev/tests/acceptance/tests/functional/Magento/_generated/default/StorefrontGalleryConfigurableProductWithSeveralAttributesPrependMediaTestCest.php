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
 * @Title("MC-26396: Storefront Gallery - Configurable Product with several attributes: prepend variation media")
 * @Description("Storefront Gallery - Configurable Product with several attributes: prepend variation media<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/StorefrontGalleryConfigurableProductWithSeveralAttributesPrependMediaTest.xml<br>")
 * @TestCaseId("MC-26396")
 * @group catalog
 * @group configurableProduct
 * @group swatch
 */
class StorefrontGalleryConfigurableProductWithSeveralAttributesPrependMediaTestCest
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
		$I->comment("Create 1 configurable product with 2 variations");
		$I->createEntity("createConfigurableProduct", "hook", "ApiConfigurableProductWithDescription", [], []); // stepKey: createConfigurableProduct
		$I->comment("Create product drop down attribute");
		$I->createEntity("createDropdownAttribute", "hook", "productDropDownAttribute", [], []); // stepKey: createDropdownAttribute
		$I->createEntity("dropdownAttributeFirstOption", "hook", "productAttributeOption1", ["createDropdownAttribute"], []); // stepKey: dropdownAttributeFirstOption
		$I->createEntity("dropdownAttributeSecondOption", "hook", "productAttributeOption2", ["createDropdownAttribute"], []); // stepKey: dropdownAttributeSecondOption
		$I->comment("Create product swatch attribute with 2 variations");
		$I->createEntity("createVisualSwatchAttribute", "hook", "VisualSwatchProductAttributeForm", [], []); // stepKey: createVisualSwatchAttribute
		$I->createEntity("swatchAttributeFirstOption", "hook", "SwatchProductAttributeOption1", ["createVisualSwatchAttribute"], []); // stepKey: swatchAttributeFirstOption
		$I->createEntity("swatchAttributeSecondOption", "hook", "SwatchProductAttributeOption2", ["createVisualSwatchAttribute"], []); // stepKey: swatchAttributeSecondOption
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
		$I->comment("Add attributes to configurable product");
		$I->conditionalClick(".admin__collapsible-block-wrapper[data-index='configurable']", "button[data-index='create_configurable_products_button']", false); // stepKey: openConfigurationSection
		$I->waitForPageLoad(30); // stepKey: openConfigurationSectionWaitForPageLoad
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: openConfigurationPanel
		$I->waitForPageLoad(30); // stepKey: openConfigurationPanelWaitForPageLoad
		$I->comment("Find Dropdown attribute in grid and select it");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearAttributeGridFiltersToFindDropdownAttribute
		$I->waitForPageLoad(30); // stepKey: clearAttributeGridFiltersToFindDropdownAttributeWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersPaneForDropdownAttribute
		$I->waitForPageLoad(30); // stepKey: openFiltersPaneForDropdownAttributeWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='attribute_code']", $I->retrieveEntityField('createDropdownAttribute', 'attribute_code', 'hook')); // stepKey: fillAttributeCodeFilterFieldForDropdownAttribute
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonForDropdownAttribute
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonForDropdownAttributeWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1) td.data-grid-checkbox-cell input"); // stepKey: selectDropdownAttribute
		$I->comment("Find Swatch attribute in grid and select it");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearAttributeGridFiltersToFindSwatchAttribute
		$I->waitForPageLoad(30); // stepKey: clearAttributeGridFiltersToFindSwatchAttributeWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersPaneForSwatchAttribute
		$I->waitForPageLoad(30); // stepKey: openFiltersPaneForSwatchAttributeWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='attribute_code']", $I->retrieveEntityField('createVisualSwatchAttribute', 'attribute_code', 'hook')); // stepKey: fillAttributeCodeFilterFieldForSwatchAttribute
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonForSwatchAttribute
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonForSwatchAttributeWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1) td.data-grid-checkbox-cell input"); // stepKey: selectSwatchAttribute
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickNextToSelectOptions
		$I->waitForPageLoad(30); // stepKey: clickNextToSelectOptionsWaitForPageLoad
		$I->click("//div[@data-attribute-title='" . $I->retrieveEntityField('createDropdownAttribute', 'default_frontend_label', 'hook') . "']//button[contains(@class, 'action-select-all')]"); // stepKey: selectAllDropdownAttributeOptions
		$I->click("//div[@data-attribute-title='" . $I->retrieveEntityField('createVisualSwatchAttribute', 'frontend_label[0]', 'hook') . "']//button[contains(@class, 'action-select-all')]"); // stepKey: selectAllSwatchAttributeOptions
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickNextToApplyQuantity
		$I->waitForPageLoad(30); // stepKey: clickNextToApplyQuantityWaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSku
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "100"); // stepKey: enterAttributeQuantity
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextToProceedToSummary
		$I->waitForPageLoad(30); // stepKey: clickOnNextToProceedToSummaryWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickGenerateProductsButton
		$I->waitForPageLoad(30); // stepKey: clickGenerateProductsButtonWaitForPageLoad
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
		$I->comment("Load media for configurable product variation option1-option1");
		$I->comment("Entering Action Group [openConfigurableProductVariationOption1Option1] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageOpenConfigurableProductVariationOption1Option1
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadOpenConfigurableProductVariationOption1Option1
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersOpenConfigurableProductVariationOption1Option1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersOpenConfigurableProductVariationOption1Option1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersOpenConfigurableProductVariationOption1Option1
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigurableProduct', 'sku', 'hook') . "-" . $I->retrieveEntityField('dropdownAttributeFirstOption', 'option[store_labels][0][label]', 'hook') . "-" . $I->retrieveEntityField('swatchAttributeFirstOption', 'option[store_labels][0][label]', 'hook')); // stepKey: fillProductSkuFilterOpenConfigurableProductVariationOption1Option1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersOpenConfigurableProductVariationOption1Option1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersOpenConfigurableProductVariationOption1Option1WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadOpenConfigurableProductVariationOption1Option1
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createConfigurableProduct', 'sku', 'hook') . "-" . $I->retrieveEntityField('dropdownAttributeFirstOption', 'option[store_labels][0][label]', 'hook') . "-" . $I->retrieveEntityField('swatchAttributeFirstOption', 'option[store_labels][0][label]', 'hook') . "']]"); // stepKey: openSelectedProductOpenConfigurableProductVariationOption1Option1
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadOpenConfigurableProductVariationOption1Option1
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleOpenConfigurableProductVariationOption1Option1
		$I->comment("Exiting Action Group [openConfigurableProductVariationOption1Option1] FilterAndSelectProductActionGroup");
		$I->comment("Entering Action Group [addFirstImageToConfigurableProductVariationOption1Option1] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddFirstImageToConfigurableProductVariationOption1Option1
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddFirstImageToConfigurableProductVariationOption1Option1
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddFirstImageToConfigurableProductVariationOption1Option1
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileAddFirstImageToConfigurableProductVariationOption1Option1
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddFirstImageToConfigurableProductVariationOption1Option1
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddFirstImageToConfigurableProductVariationOption1Option1
		$I->comment("Exiting Action Group [addFirstImageToConfigurableProductVariationOption1Option1] AddProductImageActionGroup");
		$I->comment("Entering Action Group [addSecondImageToConfigurableProductVariationOption1Option1] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddSecondImageToConfigurableProductVariationOption1Option1
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddSecondImageToConfigurableProductVariationOption1Option1
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddSecondImageToConfigurableProductVariationOption1Option1
		$I->attachFile("#fileupload", "magento-again.jpg"); // stepKey: uploadFileAddSecondImageToConfigurableProductVariationOption1Option1
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddSecondImageToConfigurableProductVariationOption1Option1
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]", 30); // stepKey: waitForThumbnailAddSecondImageToConfigurableProductVariationOption1Option1
		$I->comment("Exiting Action Group [addSecondImageToConfigurableProductVariationOption1Option1] AddProductImageActionGroup");
		$I->comment("Entering Action Group [addVideoToConfigurableProductVariationOption1Option1] AdminAddProductVideoWithPreviewActionGroup");
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title", 0, -100); // stepKey: scrollToAreaAddVideoToConfigurableProductVariationOption1Option1
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductVideoSectionAddVideoToConfigurableProductVariationOption1Option1
		$I->waitForElementVisible("#add_video_button", 30); // stepKey: waitForAddVideoButtonVisibleAddVideoToConfigurableProductVariationOption1Option1
		$I->waitForPageLoad(60); // stepKey: waitForAddVideoButtonVisibleAddVideoToConfigurableProductVariationOption1Option1WaitForPageLoad
		$I->click("#add_video_button"); // stepKey: addVideoAddVideoToConfigurableProductVariationOption1Option1
		$I->waitForPageLoad(60); // stepKey: addVideoAddVideoToConfigurableProductVariationOption1Option1WaitForPageLoad
		$I->waitForElementVisible(".modal-slide.mage-new-video-dialog.form-inline._show", 30); // stepKey: waitForUrlElementVisibleslideAddVideoToConfigurableProductVariationOption1Option1
		$I->waitForElementVisible("#video_url", 60); // stepKey: waitForUrlElementVisibleAddVideoToConfigurableProductVariationOption1Option1
		$I->fillField("#video_url", "https://vimeo.com/76979871"); // stepKey: fillFieldVideoUrlAddVideoToConfigurableProductVariationOption1Option1
		$I->fillField("#video_title", "The New Vimeo Player (You Know, For Videos)"); // stepKey: fillFieldVideoTitleAddVideoToConfigurableProductVariationOption1Option1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddVideoToConfigurableProductVariationOption1Option1
		$I->waitForElementNotVisible("//button[@class='action-primary video-create-button' and @disabled='disabled']", 30); // stepKey: waitForSaveButtonVisibleAddVideoToConfigurableProductVariationOption1Option1
		$I->attachFile(".field-new_video_screenshot #new_video_screenshot", "adobe-small.jpg"); // stepKey: addPreviewImageAddVideoToConfigurableProductVariationOption1Option1
		$I->click(".action-primary.video-create-button"); // stepKey: saveVideoAddVideoToConfigurableProductVariationOption1Option1
		$I->waitForPageLoad(30); // stepKey: saveVideoAddVideoToConfigurableProductVariationOption1Option1WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearAddVideoToConfigurableProductVariationOption1Option1
		$I->comment("Exiting Action Group [addVideoToConfigurableProductVariationOption1Option1] AdminAddProductVideoWithPreviewActionGroup");
		$I->comment("Entering Action Group [assertVideoAddedToConfigurableProductVariationOption1Option1] AssertProductVideoAdminProductPageActionGroup");
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title", 0, -100); // stepKey: scrollToAreaAssertVideoAddedToConfigurableProductVariationOption1Option1
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductVideoSectionAssertVideoAddedToConfigurableProductVariationOption1Option1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertVideoAddedToConfigurableProductVariationOption1Option1
		$I->seeElement("//*[@id='media_gallery_content']//div[contains(text(), 'The New Vimeo Player')]"); // stepKey: seeVideoTitleAssertVideoAddedToConfigurableProductVariationOption1Option1
		$I->seeElementInDOM("//*[@id='media_gallery_content']//input[@value='https://vimeo.com/76979871']"); // stepKey: seeVideoItemAssertVideoAddedToConfigurableProductVariationOption1Option1
		$I->comment("Exiting Action Group [assertVideoAddedToConfigurableProductVariationOption1Option1] AssertProductVideoAdminProductPageActionGroup");
		$I->comment("Entering Action Group [saveConfigurableProductVariationOption1Option1] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveConfigurableProductVariationOption1Option1
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveConfigurableProductVariationOption1Option1
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveConfigurableProductVariationOption1Option1WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveConfigurableProductVariationOption1Option1
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveConfigurableProductVariationOption1Option1WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveConfigurableProductVariationOption1Option1
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveConfigurableProductVariationOption1Option1
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveConfigurableProductVariationOption1Option1
		$I->comment("Exiting Action Group [saveConfigurableProductVariationOption1Option1] SaveProductFormActionGroup");
		$I->comment("Load media for configurable product variation option1-option2");
		$I->comment("Entering Action Group [openConfigurableProductVariationOption1Option2] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageOpenConfigurableProductVariationOption1Option2
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadOpenConfigurableProductVariationOption1Option2
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersOpenConfigurableProductVariationOption1Option2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersOpenConfigurableProductVariationOption1Option2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersOpenConfigurableProductVariationOption1Option2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigurableProduct', 'sku', 'hook') . "-" . $I->retrieveEntityField('dropdownAttributeFirstOption', 'option[store_labels][0][label]', 'hook') . "-" . $I->retrieveEntityField('swatchAttributeSecondOption', 'option[store_labels][0][label]', 'hook')); // stepKey: fillProductSkuFilterOpenConfigurableProductVariationOption1Option2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersOpenConfigurableProductVariationOption1Option2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersOpenConfigurableProductVariationOption1Option2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadOpenConfigurableProductVariationOption1Option2
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createConfigurableProduct', 'sku', 'hook') . "-" . $I->retrieveEntityField('dropdownAttributeFirstOption', 'option[store_labels][0][label]', 'hook') . "-" . $I->retrieveEntityField('swatchAttributeSecondOption', 'option[store_labels][0][label]', 'hook') . "']]"); // stepKey: openSelectedProductOpenConfigurableProductVariationOption1Option2
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadOpenConfigurableProductVariationOption1Option2
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleOpenConfigurableProductVariationOption1Option2
		$I->comment("Exiting Action Group [openConfigurableProductVariationOption1Option2] FilterAndSelectProductActionGroup");
		$I->comment("Entering Action Group [addFirstVideoToConfigurableProductVariationOption1Option2] AdminAddProductVideoWithPreviewActionGroup");
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title", 0, -100); // stepKey: scrollToAreaAddFirstVideoToConfigurableProductVariationOption1Option2
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductVideoSectionAddFirstVideoToConfigurableProductVariationOption1Option2
		$I->waitForElementVisible("#add_video_button", 30); // stepKey: waitForAddVideoButtonVisibleAddFirstVideoToConfigurableProductVariationOption1Option2
		$I->waitForPageLoad(60); // stepKey: waitForAddVideoButtonVisibleAddFirstVideoToConfigurableProductVariationOption1Option2WaitForPageLoad
		$I->click("#add_video_button"); // stepKey: addVideoAddFirstVideoToConfigurableProductVariationOption1Option2
		$I->waitForPageLoad(60); // stepKey: addVideoAddFirstVideoToConfigurableProductVariationOption1Option2WaitForPageLoad
		$I->waitForElementVisible(".modal-slide.mage-new-video-dialog.form-inline._show", 30); // stepKey: waitForUrlElementVisibleslideAddFirstVideoToConfigurableProductVariationOption1Option2
		$I->waitForElementVisible("#video_url", 60); // stepKey: waitForUrlElementVisibleAddFirstVideoToConfigurableProductVariationOption1Option2
		$I->fillField("#video_url", "https://vimeo.com/76979871"); // stepKey: fillFieldVideoUrlAddFirstVideoToConfigurableProductVariationOption1Option2
		$I->fillField("#video_title", "The New Vimeo Player (You Know, For Videos)"); // stepKey: fillFieldVideoTitleAddFirstVideoToConfigurableProductVariationOption1Option2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddFirstVideoToConfigurableProductVariationOption1Option2
		$I->waitForElementNotVisible("//button[@class='action-primary video-create-button' and @disabled='disabled']", 30); // stepKey: waitForSaveButtonVisibleAddFirstVideoToConfigurableProductVariationOption1Option2
		$I->attachFile(".field-new_video_screenshot #new_video_screenshot", "magento3.jpg"); // stepKey: addPreviewImageAddFirstVideoToConfigurableProductVariationOption1Option2
		$I->click(".action-primary.video-create-button"); // stepKey: saveVideoAddFirstVideoToConfigurableProductVariationOption1Option2
		$I->waitForPageLoad(30); // stepKey: saveVideoAddFirstVideoToConfigurableProductVariationOption1Option2WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearAddFirstVideoToConfigurableProductVariationOption1Option2
		$I->comment("Exiting Action Group [addFirstVideoToConfigurableProductVariationOption1Option2] AdminAddProductVideoWithPreviewActionGroup");
		$I->comment("Entering Action Group [assertFirstVideoAddedToConfigurableProductVariationOption1Option2] AssertProductVideoAdminProductPageActionGroup");
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title", 0, -100); // stepKey: scrollToAreaAssertFirstVideoAddedToConfigurableProductVariationOption1Option2
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductVideoSectionAssertFirstVideoAddedToConfigurableProductVariationOption1Option2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertFirstVideoAddedToConfigurableProductVariationOption1Option2
		$I->seeElement("//*[@id='media_gallery_content']//div[contains(text(), 'The New Vimeo Player')]"); // stepKey: seeVideoTitleAssertFirstVideoAddedToConfigurableProductVariationOption1Option2
		$I->seeElementInDOM("//*[@id='media_gallery_content']//input[@value='https://vimeo.com/76979871']"); // stepKey: seeVideoItemAssertFirstVideoAddedToConfigurableProductVariationOption1Option2
		$I->comment("Exiting Action Group [assertFirstVideoAddedToConfigurableProductVariationOption1Option2] AssertProductVideoAdminProductPageActionGroup");
		$I->comment("Entering Action Group [addFirstImageToConfigurableProductVariationOption1Option2] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddFirstImageToConfigurableProductVariationOption1Option2
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddFirstImageToConfigurableProductVariationOption1Option2
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddFirstImageToConfigurableProductVariationOption1Option2
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileAddFirstImageToConfigurableProductVariationOption1Option2
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddFirstImageToConfigurableProductVariationOption1Option2
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddFirstImageToConfigurableProductVariationOption1Option2
		$I->comment("Exiting Action Group [addFirstImageToConfigurableProductVariationOption1Option2] AddProductImageActionGroup");
		$I->comment("Entering Action Group [addSecondVideoToConfigurableProductVariationOption1Option2] AdminAddProductVideoWithPreviewActionGroup");
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title", 0, -100); // stepKey: scrollToAreaAddSecondVideoToConfigurableProductVariationOption1Option2
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductVideoSectionAddSecondVideoToConfigurableProductVariationOption1Option2
		$I->waitForElementVisible("#add_video_button", 30); // stepKey: waitForAddVideoButtonVisibleAddSecondVideoToConfigurableProductVariationOption1Option2
		$I->waitForPageLoad(60); // stepKey: waitForAddVideoButtonVisibleAddSecondVideoToConfigurableProductVariationOption1Option2WaitForPageLoad
		$I->click("#add_video_button"); // stepKey: addVideoAddSecondVideoToConfigurableProductVariationOption1Option2
		$I->waitForPageLoad(60); // stepKey: addVideoAddSecondVideoToConfigurableProductVariationOption1Option2WaitForPageLoad
		$I->waitForElementVisible(".modal-slide.mage-new-video-dialog.form-inline._show", 30); // stepKey: waitForUrlElementVisibleslideAddSecondVideoToConfigurableProductVariationOption1Option2
		$I->waitForElementVisible("#video_url", 60); // stepKey: waitForUrlElementVisibleAddSecondVideoToConfigurableProductVariationOption1Option2
		$I->fillField("#video_url", "https://vimeo.com/76979871"); // stepKey: fillFieldVideoUrlAddSecondVideoToConfigurableProductVariationOption1Option2
		$I->fillField("#video_title", "The New Vimeo Player (You Know, For Videos)"); // stepKey: fillFieldVideoTitleAddSecondVideoToConfigurableProductVariationOption1Option2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSecondVideoToConfigurableProductVariationOption1Option2
		$I->waitForElementNotVisible("//button[@class='action-primary video-create-button' and @disabled='disabled']", 30); // stepKey: waitForSaveButtonVisibleAddSecondVideoToConfigurableProductVariationOption1Option2
		$I->attachFile(".field-new_video_screenshot #new_video_screenshot", "adobe-thumb.jpg"); // stepKey: addPreviewImageAddSecondVideoToConfigurableProductVariationOption1Option2
		$I->click(".action-primary.video-create-button"); // stepKey: saveVideoAddSecondVideoToConfigurableProductVariationOption1Option2
		$I->waitForPageLoad(30); // stepKey: saveVideoAddSecondVideoToConfigurableProductVariationOption1Option2WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearAddSecondVideoToConfigurableProductVariationOption1Option2
		$I->comment("Exiting Action Group [addSecondVideoToConfigurableProductVariationOption1Option2] AdminAddProductVideoWithPreviewActionGroup");
		$I->comment("Entering Action Group [assertSecondVideoAddedToConfigurableProductVariationOption1Option2] AssertProductVideoAdminProductPageActionGroup");
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title", 0, -100); // stepKey: scrollToAreaAssertSecondVideoAddedToConfigurableProductVariationOption1Option2
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductVideoSectionAssertSecondVideoAddedToConfigurableProductVariationOption1Option2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertSecondVideoAddedToConfigurableProductVariationOption1Option2
		$I->seeElement("//*[@id='media_gallery_content']//div[contains(text(), 'The New Vimeo Player')]"); // stepKey: seeVideoTitleAssertSecondVideoAddedToConfigurableProductVariationOption1Option2
		$I->seeElementInDOM("//*[@id='media_gallery_content']//input[@value='https://vimeo.com/76979871']"); // stepKey: seeVideoItemAssertSecondVideoAddedToConfigurableProductVariationOption1Option2
		$I->comment("Exiting Action Group [assertSecondVideoAddedToConfigurableProductVariationOption1Option2] AssertProductVideoAdminProductPageActionGroup");
		$I->comment("Entering Action Group [saveConfigurableProductVariationOption1Option2] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveConfigurableProductVariationOption1Option2
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveConfigurableProductVariationOption1Option2
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveConfigurableProductVariationOption1Option2WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveConfigurableProductVariationOption1Option2
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveConfigurableProductVariationOption1Option2WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveConfigurableProductVariationOption1Option2
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveConfigurableProductVariationOption1Option2
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveConfigurableProductVariationOption1Option2
		$I->comment("Exiting Action Group [saveConfigurableProductVariationOption1Option2] SaveProductFormActionGroup");
		$I->comment("Load media for configurable product variation option2-option2");
		$I->comment("Entering Action Group [openConfigurableProductVariationOption2Option2] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageOpenConfigurableProductVariationOption2Option2
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadOpenConfigurableProductVariationOption2Option2
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersOpenConfigurableProductVariationOption2Option2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersOpenConfigurableProductVariationOption2Option2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersOpenConfigurableProductVariationOption2Option2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigurableProduct', 'sku', 'hook') . "-" . $I->retrieveEntityField('dropdownAttributeSecondOption', 'option[store_labels][0][label]', 'hook') . "-" . $I->retrieveEntityField('swatchAttributeSecondOption', 'option[store_labels][0][label]', 'hook')); // stepKey: fillProductSkuFilterOpenConfigurableProductVariationOption2Option2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersOpenConfigurableProductVariationOption2Option2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersOpenConfigurableProductVariationOption2Option2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadOpenConfigurableProductVariationOption2Option2
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createConfigurableProduct', 'sku', 'hook') . "-" . $I->retrieveEntityField('dropdownAttributeSecondOption', 'option[store_labels][0][label]', 'hook') . "-" . $I->retrieveEntityField('swatchAttributeSecondOption', 'option[store_labels][0][label]', 'hook') . "']]"); // stepKey: openSelectedProductOpenConfigurableProductVariationOption2Option2
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadOpenConfigurableProductVariationOption2Option2
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleOpenConfigurableProductVariationOption2Option2
		$I->comment("Exiting Action Group [openConfigurableProductVariationOption2Option2] FilterAndSelectProductActionGroup");
		$I->comment("Entering Action Group [addFirstImageToConfigurableProductVariationOption2Option2] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddFirstImageToConfigurableProductVariationOption2Option2
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddFirstImageToConfigurableProductVariationOption2Option2
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddFirstImageToConfigurableProductVariationOption2Option2
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileAddFirstImageToConfigurableProductVariationOption2Option2
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddFirstImageToConfigurableProductVariationOption2Option2
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddFirstImageToConfigurableProductVariationOption2Option2
		$I->comment("Exiting Action Group [addFirstImageToConfigurableProductVariationOption2Option2] AddProductImageActionGroup");
		$I->comment("Entering Action Group [saveConfigurableProductVariationOption2Option2] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveConfigurableProductVariationOption2Option2
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveConfigurableProductVariationOption2Option2
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveConfigurableProductVariationOption2Option2WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveConfigurableProductVariationOption2Option2
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveConfigurableProductVariationOption2Option2WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveConfigurableProductVariationOption2Option2
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveConfigurableProductVariationOption2Option2
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveConfigurableProductVariationOption2Option2
		$I->comment("Exiting Action Group [saveConfigurableProductVariationOption2Option2] SaveProductFormActionGroup");
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
		$I->see("A total of 5 record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeDeleteSuccessMessage
		$I->comment("Entering Action Group [clearProductGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearProductGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearProductGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [deleteProductAttributeB] DeleteProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteProductAttributeB
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteProductAttributeB
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteProductAttributeBWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", $I->retrieveEntityField('createDropdownAttribute', 'attribute_code', 'hook')); // stepKey: setAttributeCodeDeleteProductAttributeB
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridDeleteProductAttributeB
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridDeleteProductAttributeBWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteProductAttributeB
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteProductAttributeBWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2DeleteProductAttributeB
		$I->click("#delete"); // stepKey: deleteAttributeDeleteProductAttributeB
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteProductAttributeBWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: ClickOnDeleteButtonDeleteProductAttributeB
		$I->waitForPageLoad(30); // stepKey: ClickOnDeleteButtonDeleteProductAttributeBWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteProductAttributeB
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessageDeleteProductAttributeB
		$I->comment("Exiting Action Group [deleteProductAttributeB] DeleteProductAttributeActionGroup");
		$I->comment("Entering Action Group [deleteProductAttributeF] DeleteProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteProductAttributeF
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteProductAttributeF
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteProductAttributeFWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", $I->retrieveEntityField('createVisualSwatchAttribute', 'attribute_code', 'hook')); // stepKey: setAttributeCodeDeleteProductAttributeF
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridDeleteProductAttributeF
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridDeleteProductAttributeFWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteProductAttributeF
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteProductAttributeFWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2DeleteProductAttributeF
		$I->click("#delete"); // stepKey: deleteAttributeDeleteProductAttributeF
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteProductAttributeFWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: ClickOnDeleteButtonDeleteProductAttributeF
		$I->waitForPageLoad(30); // stepKey: ClickOnDeleteButtonDeleteProductAttributeFWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteProductAttributeF
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessageDeleteProductAttributeF
		$I->comment("Exiting Action Group [deleteProductAttributeF] DeleteProductAttributeActionGroup");
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
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontGalleryConfigurableProductWithSeveralAttributesPrependMediaTest(AcceptanceTester $I)
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
		$I->comment("CASE 1: Selected options = F2; Expected media : E1, E2, E3, C1, C2, C3");
		$I->click("div.swatch-option[data-option-label='" . $I->retrieveEntityField('swatchAttributeSecondOption', 'option[store_labels][0][label]', 'test') . "']"); // stepKey: chooseOptionF2Case1
		$I->waitForElementVisible(".fotorama__nav__shaft img", 30); // stepKey: waitForThumbnailsAppearCase1
		$getListOfThumbnailsCase1 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsCase1
		$I->assertRegExp("|magento3.*.jpg|", $getListOfThumbnailsCase1[0]); // stepKey: checkPositionInThumbnailForImage1Case1
		$I->assertRegExp("|magento-logo.*.png|", $getListOfThumbnailsCase1[1]); // stepKey: checkPositionInThumbnailForImage2Case1
		$I->assertRegExp("|adobe-thumb.*.jpg|", $getListOfThumbnailsCase1[2]); // stepKey: checkPositionInThumbnailForImage3Case1
		$I->assertRegExp("|magento2.*.jpg|", $getListOfThumbnailsCase1[3]); // stepKey: checkPositionInThumbnailForImage4Case1
		$I->assertRegExp("|magento3.*.jpg|", $getListOfThumbnailsCase1[4]); // stepKey: checkPositionInThumbnailForImage5Case1
		$I->assertRegExp("|magento-again.*.jpg|", $getListOfThumbnailsCase1[5]); // stepKey: checkPositionInThumbnailForImage6Case1
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
		$I->comment("CASE 2: Selected options = F1; Expected media : D1, D2, D3, C1, C2, C3");
		$I->click("div.swatch-option[data-option-label='" . $I->retrieveEntityField('swatchAttributeFirstOption', 'option[store_labels][0][label]', 'test') . "']"); // stepKey: chooseOptionF1Case2
		$I->waitForElementVisible(".fotorama__nav__shaft img", 30); // stepKey: waitForThumbnailsAppearCase2
		$getListOfThumbnailsCase2 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsCase2
		$I->assertRegExp("|magento-logo.*.png|", $getListOfThumbnailsCase2[0]); // stepKey: checkPositionInThumbnailForImage1Case2
		$I->assertRegExp("|magento-again.*.jpg|", $getListOfThumbnailsCase2[1]); // stepKey: checkPositionInThumbnailForImage2Case2
		$I->assertRegExp("|adobe-small.*.jpg|", $getListOfThumbnailsCase2[2]); // stepKey: checkPositionInThumbnailForImage3Case2
		$I->assertRegExp("|magento2.*.jpg|", $getListOfThumbnailsCase2[3]); // stepKey: checkPositionInThumbnailForImage4Case2
		$I->assertRegExp("|magento3.*.jpg|", $getListOfThumbnailsCase2[4]); // stepKey: checkPositionInThumbnailForImage5Case2
		$I->assertRegExp("|magento-again.*.jpg|", $getListOfThumbnailsCase2[5]); // stepKey: checkPositionInThumbnailForImage6Case2
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
		$I->comment("CASE 3: Selected options = B2,F1; Expected media : C1, C2, C3");
		$I->selectOption("//div[@class='fieldset']//div[//span[text()='" . $I->retrieveEntityField('createDropdownAttribute', 'default_frontend_label', 'test') . "']]//select", $I->retrieveEntityField('dropdownAttributeSecondOption', 'option[store_labels][0][label]', 'test')); // stepKey: chooseOptionB2Case3
		$I->waitForElementVisible(".fotorama__nav__shaft img", 30); // stepKey: waitForThumbnailsAppearCase3
		$getListOfThumbnailsCase3 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsCase3
		$I->assertRegExp("|magento2.*.jpg|", $getListOfThumbnailsCase3[0]); // stepKey: checkPositionInThumbnailForImage1Case3
		$I->assertRegExp("|magento3.*.jpg|", $getListOfThumbnailsCase3[1]); // stepKey: checkPositionInThumbnailForImage2Case3
		$I->assertRegExp("|magento-again.*.jpg|", $getListOfThumbnailsCase3[2]); // stepKey: checkPositionInThumbnailForImage3Case3
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
		$I->comment("CASE 4: Selected options = B2,F2, Expected media : G1, C1, C2, C3");
		$I->click("div.swatch-option[data-option-label='" . $I->retrieveEntityField('swatchAttributeSecondOption', 'option[store_labels][0][label]', 'test') . "']"); // stepKey: chooseOptionF2Case4
		$I->waitForElementVisible(".fotorama__nav__shaft img", 30); // stepKey: waitForThumbnailsAppearCase4
		$getListOfThumbnailsCase4 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsCase4
		$I->assertRegExp("|magento-logo.*.png|", $getListOfThumbnailsCase4[0]); // stepKey: checkPositionInThumbnailForImage1Case4
		$I->assertRegExp("|magento2.*.jpg|", $getListOfThumbnailsCase4[1]); // stepKey: checkPositionInThumbnailForImage2Case4
		$I->assertRegExp("|magento3.*.jpg|", $getListOfThumbnailsCase4[2]); // stepKey: checkPositionInThumbnailForImage3Case4
		$I->assertRegExp("|magento-again.*.jpg|", $getListOfThumbnailsCase4[3]); // stepKey: checkPositionInThumbnailForImage4Case4
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
		$I->comment("CASE 5: Selected options = B2, Expected media : C1, C2, C3");
		$I->conditionalClick("#product-options-wrapper .swatch-option.selected", "#product-options-wrapper .swatch-option.selected", true); // stepKey: unchooseF2Case5
		$I->waitForElementVisible(".fotorama__nav__shaft img", 30); // stepKey: waitForThumbnailsAppearCase5
		$getListOfThumbnailsCase5 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsCase5
		$I->assertRegExp("|magento2.*.jpg|", $getListOfThumbnailsCase5[0]); // stepKey: checkPositionInThumbnailForImage1Case5
		$I->assertRegExp("|magento3.*.jpg|", $getListOfThumbnailsCase5[1]); // stepKey: checkPositionInThumbnailForImage2Case5
		$I->assertRegExp("|magento-again.*.jpg|", $getListOfThumbnailsCase5[2]); // stepKey: checkPositionInThumbnailForImage3Case5
		$I->comment("Entering Action Group [openFullScreenPageCase5] StorefrontProductPageOpenImageFullscreenActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", 30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase5
		$I->waitForPageLoad(30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase5WaitForPageLoad
		$I->conditionalClick("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", "//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb') and contains(@class, 'fotorama__active')][2]", false); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase5
		$I->waitForPageLoad(30); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase5WaitForPageLoad
		$I->click("[data-gallery-role='gallery']"); // stepKey: openFullScreenPageOpenFullScreenPageCase5
		$I->waitForPageLoad(30); // stepKey: openFullScreenPageOpenFullScreenPageCase5WaitForPageLoad
		$I->comment("Exiting Action Group [openFullScreenPageCase5] StorefrontProductPageOpenImageFullscreenActionGroup");
		$getListOfThumbnailsFullScreenPageCase5 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsFullScreenPageCase5
		$I->assertEquals($getListOfThumbnailsCase5, $getListOfThumbnailsFullScreenPageCase5); // stepKey: checkPositionInThumbnailForImagesFromFullScreenPageCase5
		$I->comment("Entering Action Group [closeFullScreenPageCase5] StorefrontProductPageCloseFullscreenGalleryActionGroup");
		$I->click("//*[@data-gallery-role='gallery' and contains(@class, 'fullscreen')]//*[@data-gallery-role='fotorama__fullscreen-icon']"); // stepKey: closeFullScreenPageCloseFullScreenPageCase5
		$I->waitForPageLoad(30); // stepKey: waitsForCloseFullScreenPageCloseFullScreenPageCase5
		$I->comment("Exiting Action Group [closeFullScreenPageCase5] StorefrontProductPageCloseFullscreenGalleryActionGroup");
		$I->comment("CASE 6: Selected options = B1, Expected media : D1, D2, D3, C1, C2, C3");
		$I->selectOption("//div[@class='fieldset']//div[//span[text()='" . $I->retrieveEntityField('createDropdownAttribute', 'default_frontend_label', 'test') . "']]//select", $I->retrieveEntityField('dropdownAttributeFirstOption', 'option[store_labels][0][label]', 'test')); // stepKey: chooseOptionB1Case6
		$I->waitForElementVisible(".fotorama__nav__shaft img", 30); // stepKey: waitForThumbnailsAppearCase6
		$getListOfThumbnailsCase6 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsCase6
		$I->assertRegExp("|magento-logo.*.png|", $getListOfThumbnailsCase6[0]); // stepKey: checkPositionInThumbnailForImage1Case6
		$I->assertRegExp("|magento-again.*.jpg|", $getListOfThumbnailsCase6[1]); // stepKey: checkPositionInThumbnailForImage2Case6
		$I->assertRegExp("|adobe-small.*.jpg|", $getListOfThumbnailsCase6[2]); // stepKey: checkPositionInThumbnailForImage3Case6
		$I->assertRegExp("|magento2.*.jpg|", $getListOfThumbnailsCase6[3]); // stepKey: checkPositionInThumbnailForImage4Case6
		$I->assertRegExp("|magento3.*.jpg|", $getListOfThumbnailsCase6[4]); // stepKey: checkPositionInThumbnailForImage5Case6
		$I->assertRegExp("|magento-again.*.jpg|", $getListOfThumbnailsCase6[5]); // stepKey: checkPositionInThumbnailForImage6Case6
		$I->comment("Entering Action Group [openFullScreenPageCase6] StorefrontProductPageOpenImageFullscreenActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", 30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase6
		$I->waitForPageLoad(30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase6WaitForPageLoad
		$I->conditionalClick("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", "//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb') and contains(@class, 'fotorama__active')][2]", false); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase6
		$I->waitForPageLoad(30); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase6WaitForPageLoad
		$I->click("[data-gallery-role='gallery']"); // stepKey: openFullScreenPageOpenFullScreenPageCase6
		$I->waitForPageLoad(30); // stepKey: openFullScreenPageOpenFullScreenPageCase6WaitForPageLoad
		$I->comment("Exiting Action Group [openFullScreenPageCase6] StorefrontProductPageOpenImageFullscreenActionGroup");
		$getListOfThumbnailsFullScreenPageCase6 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsFullScreenPageCase6
		$I->assertEquals($getListOfThumbnailsCase6, $getListOfThumbnailsFullScreenPageCase6); // stepKey: checkPositionInThumbnailForImagesFromFullScreenPageCase6
		$I->comment("Entering Action Group [closeFullScreenPageCase6] StorefrontProductPageCloseFullscreenGalleryActionGroup");
		$I->click("//*[@data-gallery-role='gallery' and contains(@class, 'fullscreen')]//*[@data-gallery-role='fotorama__fullscreen-icon']"); // stepKey: closeFullScreenPageCloseFullScreenPageCase6
		$I->waitForPageLoad(30); // stepKey: waitsForCloseFullScreenPageCloseFullScreenPageCase6
		$I->comment("Exiting Action Group [closeFullScreenPageCase6] StorefrontProductPageCloseFullscreenGalleryActionGroup");
		$I->comment("CASE 7: Selected options = B1,F2, Expected media : E1, E2, E3, C1, C2, C3");
		$I->click("div.swatch-option[data-option-label='" . $I->retrieveEntityField('swatchAttributeSecondOption', 'option[store_labels][0][label]', 'test') . "']"); // stepKey: chooseOptionF2Case7
		$I->waitForElementVisible(".fotorama__nav__shaft img", 30); // stepKey: waitForThumbnailsAppearCase7
		$getListOfThumbnailsCase7 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsCase7
		$I->assertRegExp("|magento3.*.jpg|", $getListOfThumbnailsCase7[0]); // stepKey: checkPositionInThumbnailForImage1Case7
		$I->assertRegExp("|magento-logo.*.png|", $getListOfThumbnailsCase7[1]); // stepKey: checkPositionInThumbnailForImage2Case7
		$I->assertRegExp("|adobe-thumb.*.jpg|", $getListOfThumbnailsCase7[2]); // stepKey: checkPositionInThumbnailForImage3Case7
		$I->assertRegExp("|magento2.*.jpg|", $getListOfThumbnailsCase7[3]); // stepKey: checkPositionInThumbnailForImage4Case7
		$I->assertRegExp("|magento3.*.jpg|", $getListOfThumbnailsCase7[4]); // stepKey: checkPositionInThumbnailForImage5Case7
		$I->assertRegExp("|magento-again.*.jpg|", $getListOfThumbnailsCase7[5]); // stepKey: checkPositionInThumbnailForImage6Case7
		$I->comment("Entering Action Group [openFullScreenPageCase7] StorefrontProductPageOpenImageFullscreenActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", 30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase7
		$I->waitForPageLoad(30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase7WaitForPageLoad
		$I->conditionalClick("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", "//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb') and contains(@class, 'fotorama__active')][2]", false); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase7
		$I->waitForPageLoad(30); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase7WaitForPageLoad
		$I->click("[data-gallery-role='gallery']"); // stepKey: openFullScreenPageOpenFullScreenPageCase7
		$I->waitForPageLoad(30); // stepKey: openFullScreenPageOpenFullScreenPageCase7WaitForPageLoad
		$I->comment("Exiting Action Group [openFullScreenPageCase7] StorefrontProductPageOpenImageFullscreenActionGroup");
		$getListOfThumbnailsFullScreenPageCase7 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsFullScreenPageCase7
		$I->assertEquals($getListOfThumbnailsCase7, $getListOfThumbnailsFullScreenPageCase7); // stepKey: checkPositionInThumbnailForImagesFromFullScreenPageCase7
		$I->comment("Entering Action Group [closeFullScreenPageCase7] StorefrontProductPageCloseFullscreenGalleryActionGroup");
		$I->click("//*[@data-gallery-role='gallery' and contains(@class, 'fullscreen')]//*[@data-gallery-role='fotorama__fullscreen-icon']"); // stepKey: closeFullScreenPageCloseFullScreenPageCase7
		$I->waitForPageLoad(30); // stepKey: waitsForCloseFullScreenPageCloseFullScreenPageCase7
		$I->comment("Exiting Action Group [closeFullScreenPageCase7] StorefrontProductPageCloseFullscreenGalleryActionGroup");
		$I->comment("CASE 8: Selected options = B1,F1, Expected media : D1, D2, D3, C1, C2, C3");
		$I->click("div.swatch-option[data-option-label='" . $I->retrieveEntityField('swatchAttributeFirstOption', 'option[store_labels][0][label]', 'test') . "']"); // stepKey: chooseOptionF1Case8
		$I->waitForElementVisible(".fotorama__nav__shaft img", 30); // stepKey: waitForThumbnailsAppearCase8
		$getListOfThumbnailsCase8 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsCase8
		$I->assertRegExp("|magento-logo.*.png|", $getListOfThumbnailsCase8[0]); // stepKey: checkPositionInThumbnailForImage1Case8
		$I->assertRegExp("|magento-again.*.jpg|", $getListOfThumbnailsCase8[1]); // stepKey: checkPositionInThumbnailForImage2Case8
		$I->assertRegExp("|adobe-small.*.jpg|", $getListOfThumbnailsCase8[2]); // stepKey: checkPositionInThumbnailForImage3Case8
		$I->assertRegExp("|magento2.*.jpg|", $getListOfThumbnailsCase8[3]); // stepKey: checkPositionInThumbnailForImage4Case8
		$I->assertRegExp("|magento3.*.jpg|", $getListOfThumbnailsCase8[4]); // stepKey: checkPositionInThumbnailForImage5Case8
		$I->assertRegExp("|magento-again.*.jpg|", $getListOfThumbnailsCase8[5]); // stepKey: checkPositionInThumbnailForImage6Case8
		$I->comment("Entering Action Group [openFullScreenPageCase8] StorefrontProductPageOpenImageFullscreenActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", 30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase8
		$I->waitForPageLoad(30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase8WaitForPageLoad
		$I->conditionalClick("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", "//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb') and contains(@class, 'fotorama__active')][2]", false); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase8
		$I->waitForPageLoad(30); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase8WaitForPageLoad
		$I->click("[data-gallery-role='gallery']"); // stepKey: openFullScreenPageOpenFullScreenPageCase8
		$I->waitForPageLoad(30); // stepKey: openFullScreenPageOpenFullScreenPageCase8WaitForPageLoad
		$I->comment("Exiting Action Group [openFullScreenPageCase8] StorefrontProductPageOpenImageFullscreenActionGroup");
		$getListOfThumbnailsFullScreenPageCase8 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsFullScreenPageCase8
		$I->assertEquals($getListOfThumbnailsCase8, $getListOfThumbnailsFullScreenPageCase8); // stepKey: checkPositionInThumbnailForImagesFromFullScreenPageCase8
		$I->comment("Entering Action Group [closeFullScreenPageCase8] StorefrontProductPageCloseFullscreenGalleryActionGroup");
		$I->click("//*[@data-gallery-role='gallery' and contains(@class, 'fullscreen')]//*[@data-gallery-role='fotorama__fullscreen-icon']"); // stepKey: closeFullScreenPageCloseFullScreenPageCase8
		$I->waitForPageLoad(30); // stepKey: waitsForCloseFullScreenPageCloseFullScreenPageCase8
		$I->comment("Exiting Action Group [closeFullScreenPageCase8] StorefrontProductPageCloseFullscreenGalleryActionGroup");
		$I->comment("CASE 9: Selected options = none, Expected media : C1, C2, C3");
		$I->selectOption("//div[@class='fieldset']//div[//span[text()='" . $I->retrieveEntityField('createDropdownAttribute', 'default_frontend_label', 'test') . "']]//select", "Choose an Option..."); // stepKey: unselectB1Case9
		$I->conditionalClick("#product-options-wrapper .swatch-option.selected", "#product-options-wrapper .swatch-option.selected", true); // stepKey: unchooseF1Case9
		$I->waitForElementVisible(".fotorama__nav__shaft img", 30); // stepKey: waitForThumbnailsAppearCase9
		$getListOfThumbnailsCase9 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsCase9
		$I->assertRegExp("|magento2.*.jpg|", $getListOfThumbnailsCase9[0]); // stepKey: checkPositionInThumbnailForImage1Case9
		$I->assertRegExp("|magento3.*.jpg|", $getListOfThumbnailsCase9[1]); // stepKey: checkPositionInThumbnailForImage2Case9
		$I->assertRegExp("|magento-again.*.jpg|", $getListOfThumbnailsCase9[2]); // stepKey: checkPositionInThumbnailForImage3Case9
		$I->comment("Entering Action Group [openFullScreenPageCase9] StorefrontProductPageOpenImageFullscreenActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", 30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase9
		$I->waitForPageLoad(30); // stepKey: waitThumbnailAppearsOpenFullScreenPageCase9WaitForPageLoad
		$I->conditionalClick("//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb')][2]", "//div[contains(@class, 'fotorama__nav__shaft')]//div[contains(@class, 'fotorama__nav__frame--thumb') and contains(@class, 'fotorama__active')][2]", false); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase9
		$I->waitForPageLoad(30); // stepKey: clickOnThumbnailImageOpenFullScreenPageCase9WaitForPageLoad
		$I->click("[data-gallery-role='gallery']"); // stepKey: openFullScreenPageOpenFullScreenPageCase9
		$I->waitForPageLoad(30); // stepKey: openFullScreenPageOpenFullScreenPageCase9WaitForPageLoad
		$I->comment("Exiting Action Group [openFullScreenPageCase9] StorefrontProductPageOpenImageFullscreenActionGroup");
		$getListOfThumbnailsFullScreenPageCase9 = $I->grabMultiple(".fotorama__nav__shaft img", "src"); // stepKey: getListOfThumbnailsFullScreenPageCase9
		$I->assertEquals($getListOfThumbnailsCase9, $getListOfThumbnailsFullScreenPageCase9); // stepKey: checkPositionInThumbnailForImagesFromFullScreenPageCase9
		$I->comment("Entering Action Group [closeFullScreenPageCase9] StorefrontProductPageCloseFullscreenGalleryActionGroup");
		$I->click("//*[@data-gallery-role='gallery' and contains(@class, 'fullscreen')]//*[@data-gallery-role='fotorama__fullscreen-icon']"); // stepKey: closeFullScreenPageCloseFullScreenPageCase9
		$I->waitForPageLoad(30); // stepKey: waitsForCloseFullScreenPageCloseFullScreenPageCase9
		$I->comment("Exiting Action Group [closeFullScreenPageCase9] StorefrontProductPageCloseFullscreenGalleryActionGroup");
	}
}
