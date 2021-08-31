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
 * @Title("MC-11531: Image color when filtering by color filter on the Storefront")
 * @Description("Image color when filtering by color filter on the Storefront<h3>Test files</h3>app/code/Magento/Swatches/Test/Mftf/Test/StorefrontImageColorWhenFilterByColorFilterTest.xml<br>")
 * @TestCaseId("MC-11531")
 * @group Swatches
 */
class StorefrontImageColorWhenFilterByColorFilterTestCest
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
		$I->comment("Create category and configurable product with two options");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
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
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->comment("Entering Action Group [deleteAttribute] AdminDeleteProductAttributeByLabelActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: waitForProductAttributeGridPageLoadDeleteAttribute
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridDeleteAttributeWaitForPageLoad
		$I->fillField("//input[@name='frontend_label']", "VisualSwatchAttr" . msq("visualSwatchAttribute")); // stepKey: setAttributeLabelFilterDeleteAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeLabelFromTheGridDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeLabelFromTheGridDeleteAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteAttributeWaitForPageLoad
		$I->click("#delete"); // stepKey: clickOnDeleteAttributeButtonDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteAttributeButtonDeleteAttributeWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmationPopUpVisibleDeleteAttribute
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOnConfirmationButtonDeleteAttribute
		$I->waitForPageLoad(60); // stepKey: clickOnConfirmationButtonDeleteAttributeWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageVisibleDeleteAttribute
		$I->see("You deleted the product attribute.", "#messages div.message-success"); // stepKey: seeAttributeDeleteSuccessMessageDeleteAttribute
		$I->comment("Exiting Action Group [deleteAttribute] AdminDeleteProductAttributeByLabelActionGroup");
		$I->comment("Entering Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageOpenProductIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadOpenProductIndexPage
		$I->comment("Exiting Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [clearGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearGridFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearGridFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [selectNumberOfProductsPerPage] AdminDataGridSelectPerPageActionGroup");
		$I->click(".admin__data-grid-pager-wrap .selectmenu"); // stepKey: clickPerPageDropdownSelectNumberOfProductsPerPage
		$I->click("//div[@class='admin__data-grid-pager-wrap']//div[@class='selectmenu-items _active']//li//button[text()='100']"); // stepKey: selectCustomPerPageSelectNumberOfProductsPerPage
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadSelectNumberOfProductsPerPage
		$I->comment("Exiting Action Group [selectNumberOfProductsPerPage] AdminDataGridSelectPerPageActionGroup");
		$I->comment("Entering Action Group [deleteAllProducts] DeleteProductsIfTheyExistActionGroup");
		$I->conditionalClick("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", "table.data-grid tr.data-row:first-of-type", true); // stepKey: openMulticheckDropdownDeleteAllProducts
		$I->conditionalClick("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']", "table.data-grid tr.data-row:first-of-type", true); // stepKey: selectAllProductInFilteredGridDeleteAllProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteAllProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteAllProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteAllProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteAllProductsWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm button.action-accept", 30); // stepKey: waitForModalPopUpDeleteAllProducts
		$I->waitForPageLoad(60); // stepKey: waitForModalPopUpDeleteAllProductsWaitForPageLoad
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteAllProducts
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteAllProductsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadDeleteAllProducts
		$I->comment("Exiting Action Group [deleteAllProducts] DeleteProductsIfTheyExistActionGroup");
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
	 * @Stories({"Color image when filtering by color filter"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontImageColorWhenFilterByColorFilterTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToConfigProductPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigProduct', 'id', 'test')); // stepKey: goToProductNavigateToConfigProductPage
		$I->comment("Exiting Action Group [navigateToConfigProductPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->comment("Create visual swatch attribute");
		$I->comment("Entering Action Group [addSwatchToProduct] AddVisualSwatchWithProductWithStorefrontPreviewImageConfigActionGroup");
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
		$I->selectOption("#update_product_preview_image", "Yes"); // stepKey: selectUpdatePreviewImageAddSwatchToProduct
		$I->comment("Add swatch options");
		$I->click("button#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch1AddSwatchToProduct
		$I->waitForElementVisible("[data-role='swatch-visual-options-container'] input[name='optionvisual[value][option_0][0]']", 30); // stepKey: waitForOption1RowAddSwatchToProduct
		$I->fillField("[data-role='swatch-visual-options-container'] input[name='optionvisual[value][option_0][0]']", "VisualOpt1" . msq("visualSwatchOption1")); // stepKey: fillAdminLabel1AddSwatchToProduct
		$I->fillField("[data-role='swatch-visual-options-container'] input[name='optionvisual[value][option_0][1]']", "VisualOpt1" . msq("visualSwatchOption1")); // stepKey: fillDefaultStoreLabel1AddSwatchToProduct
		$I->click("button#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch2AddSwatchToProduct
		$I->waitForElementVisible("[data-role='swatch-visual-options-container'] input[name='optionvisual[value][option_1][0]']", 30); // stepKey: waitForOption2RowAddSwatchToProduct
		$I->fillField("[data-role='swatch-visual-options-container'] input[name='optionvisual[value][option_1][0]']", "VisualOpt2" . msq("visualSwatchOption2")); // stepKey: fillAdminLabel2AddSwatchToProduct
		$I->fillField("[data-role='swatch-visual-options-container'] input[name='optionvisual[value][option_1][1]']", "VisualOpt2" . msq("visualSwatchOption2")); // stepKey: fillDefaultStoreLabel2AddSwatchToProduct
		$I->click("#front_fieldset-wrapper"); // stepKey: goToStorefrontPropertiesTabAddSwatchToProduct
		$I->waitForElementVisible("//span[text()='Storefront Properties']", 30); // stepKey: waitTabLoadAddSwatchToProduct
		$I->selectOption("#is_filterable", "Filterable (with results)"); // stepKey: selectUseInLayerAddSwatchToProduct
		$I->selectOption("#used_in_product_listing", "Yes"); // stepKey: switchOnUsedInProductListingAddSwatchToProduct
		$I->selectOption("#used_for_sort_by", "Yes"); // stepKey: switchOnUsedForStoringInProductListingAddSwatchToProduct
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
		$I->comment("Exiting Action Group [addSwatchToProduct] AddVisualSwatchWithProductWithStorefrontPreviewImageConfigActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickEditConfigurations
		$I->waitForPageLoad(30); // stepKey: clickEditConfigurationsWaitForPageLoad
		$I->see("Select Attributes", "div.content:not([style='display: none;']) .steps-wizard-title"); // stepKey: seeStepTitle
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1WaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2WaitForPageLoad
		$I->comment("Add images to product attribute options");
		$I->comment("Entering Action Group [addImageToConfigurableProductOptionOne] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-images-radio']"); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionOne
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionOneWaitForPageLoad
		$I->selectOption("#apply-images-attributes", "VisualSwatchAttr" . msq("visualSwatchAttribute")); // stepKey: selectOptionAddImageToConfigurableProductOptionOne
		$I->waitForPageLoad(30); // stepKey: selectOptionAddImageToConfigurableProductOptionOneWaitForPageLoad
		$I->attachFile("//*[text()='VisualOpt1" . msq("visualSwatchOption1") . "']/../../div[@data-role='gallery']//input[@type='file']", "magento-logo.png"); // stepKey: uploadFileAddImageToConfigurableProductOptionOne
		$I->waitForPageLoad(30); // stepKey: uploadFileAddImageToConfigurableProductOptionOneWaitForPageLoad
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageToConfigurableProductOptionOne
		$I->waitForElementVisible("//*[@data-role='gallery']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddImageToConfigurableProductOptionOne
		$I->comment("Exiting Action Group [addImageToConfigurableProductOptionOne] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->comment("Entering Action Group [addImageToConfigurableProductOptionTwo] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-images-radio']"); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionTwo
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionTwoWaitForPageLoad
		$I->selectOption("#apply-images-attributes", "VisualSwatchAttr" . msq("visualSwatchAttribute")); // stepKey: selectOptionAddImageToConfigurableProductOptionTwo
		$I->waitForPageLoad(30); // stepKey: selectOptionAddImageToConfigurableProductOptionTwoWaitForPageLoad
		$I->attachFile("//*[text()='VisualOpt2" . msq("visualSwatchOption2") . "']/../../div[@data-role='gallery']//input[@type='file']", "magento-again.jpg"); // stepKey: uploadFileAddImageToConfigurableProductOptionTwo
		$I->waitForPageLoad(30); // stepKey: uploadFileAddImageToConfigurableProductOptionTwoWaitForPageLoad
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageToConfigurableProductOptionTwo
		$I->waitForElementVisible("//*[@data-role='gallery']//img[contains(@src, 'magento-again')]", 30); // stepKey: waitForThumbnailAddImageToConfigurableProductOptionTwo
		$I->comment("Exiting Action Group [addImageToConfigurableProductOptionTwo] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnGenerateProductsButton
		$I->waitForPageLoad(30); // stepKey: clickOnGenerateProductsButtonWaitForPageLoad
		$I->comment("Entering Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductForm
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductForm
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductFormWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductForm
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductFormWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductForm
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductForm
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductForm
		$I->comment("Exiting Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Select any option in the Layered navigation and verify product image");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToCategoryPage
		$I->comment("Entering Action Group [selectStorefrontProductAttributeOption] SelectStorefrontSideBarAttributeOption");
		$I->amOnPage($I->retrieveEntityField('createCategory', 'name', 'test')); // stepKey: openCategoryStoreFrontPageSelectStorefrontProductAttributeOption
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadSelectStorefrontProductAttributeOption
		$I->seeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: seeCategoryInFrontPageSelectStorefrontProductAttributeOption
		$I->waitForPageLoad(30); // stepKey: seeCategoryInFrontPageSelectStorefrontProductAttributeOptionWaitForPageLoad
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: clickOnCategorySelectStorefrontProductAttributeOption
		$I->waitForPageLoad(30); // stepKey: clickOnCategorySelectStorefrontProductAttributeOptionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoad1SelectStorefrontProductAttributeOption
		$I->seeElement("//div[@class='filter-options-title' and contains(text(), 'VisualSwatchAttr" . msq("visualSwatchAttribute") . "')]"); // stepKey: seeAttributeOptionsTitleSelectStorefrontProductAttributeOption
		$I->click("//div[@class='filter-options-title' and contains(text(), 'VisualSwatchAttr" . msq("visualSwatchAttribute") . "')]"); // stepKey: clickAttributeOptionsSelectStorefrontProductAttributeOption
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSelectStorefrontProductAttributeOption
		$I->comment("Exiting Action Group [selectStorefrontProductAttributeOption] SelectStorefrontSideBarAttributeOption");
		$I->waitForElementVisible(" div.filter-options-item div[data-option-label='VisualOpt1" . msq("visualSwatchOption1") . "']", 30); // stepKey: waitForOption
		$I->click(" div.filter-options-item div[data-option-label='VisualOpt1" . msq("visualSwatchOption1") . "']"); // stepKey: clickFirstOption
		$grabFirstOptionImg = $I->grabAttributeFrom("img.product-image-photo", "src"); // stepKey: grabFirstOptionImg
		$I->assertStringContainsString("magento-logo", $grabFirstOptionImg); // stepKey: assertProductFirstOptionImage
		$I->click("div.filter-current .remove"); // stepKey: removeSideBarFilter
		$I->waitForPageLoad(30); // stepKey: removeSideBarFilterWaitForPageLoad
		$I->comment("Entering Action Group [selectStorefrontProductAttributeForSecondOption] SelectStorefrontSideBarAttributeOption");
		$I->amOnPage($I->retrieveEntityField('createCategory', 'name', 'test')); // stepKey: openCategoryStoreFrontPageSelectStorefrontProductAttributeForSecondOption
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadSelectStorefrontProductAttributeForSecondOption
		$I->seeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: seeCategoryInFrontPageSelectStorefrontProductAttributeForSecondOption
		$I->waitForPageLoad(30); // stepKey: seeCategoryInFrontPageSelectStorefrontProductAttributeForSecondOptionWaitForPageLoad
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: clickOnCategorySelectStorefrontProductAttributeForSecondOption
		$I->waitForPageLoad(30); // stepKey: clickOnCategorySelectStorefrontProductAttributeForSecondOptionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoad1SelectStorefrontProductAttributeForSecondOption
		$I->seeElement("//div[@class='filter-options-title' and contains(text(), 'VisualSwatchAttr" . msq("visualSwatchAttribute") . "')]"); // stepKey: seeAttributeOptionsTitleSelectStorefrontProductAttributeForSecondOption
		$I->click("//div[@class='filter-options-title' and contains(text(), 'VisualSwatchAttr" . msq("visualSwatchAttribute") . "')]"); // stepKey: clickAttributeOptionsSelectStorefrontProductAttributeForSecondOption
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSelectStorefrontProductAttributeForSecondOption
		$I->comment("Exiting Action Group [selectStorefrontProductAttributeForSecondOption] SelectStorefrontSideBarAttributeOption");
		$I->waitForElementVisible(" div.filter-options-item div[data-option-label='VisualOpt2" . msq("visualSwatchOption2") . "']", 30); // stepKey: waitForSecondOption
		$I->click(" div.filter-options-item div[data-option-label='VisualOpt2" . msq("visualSwatchOption2") . "']"); // stepKey: clickSecondOption
		$grabSecondOptionImg = $I->grabAttributeFrom("img.product-image-photo", "src"); // stepKey: grabSecondOptionImg
		$I->assertStringContainsString("magento-again", $grabSecondOptionImg); // stepKey: assertProductSecondOptionImage
	}
}
