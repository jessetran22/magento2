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
 * @Title("MC-17226: Visibility of duplicate product on the Storefront")
 * @Description("Check visibility of duplicate product on the Storefront<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/StorefrontVisibilityOfDuplicateProductTest.xml<br>")
 * @TestCaseId("MC-17226")
 * @group ConfigurableProduct
 */
class StorefrontVisibilityOfDuplicateProductTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create configurable product");
		$I->comment("Create configurable product");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createConfigProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createConfigProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->comment("Delete created data");
		$I->comment("Entering Action Group [deleteDuplicatedProduct] DeleteAllDuplicateProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteDuplicatedProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteDuplicatedProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteDuplicatedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteDuplicatedProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigProduct', 'sku', 'hook')); // stepKey: fillProductSkuFilterDeleteDuplicatedProduct
		$I->fillField("input.admin__control-text[name='name']", $I->retrieveEntityField('createConfigProduct', 'name', 'hook')); // stepKey: fillProductNameFilterDeleteDuplicatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteDuplicatedProductWaitForPageLoad
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteDuplicatedProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteDuplicatedProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteDuplicatedProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteDuplicatedProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteDuplicatedProduct
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteDuplicatedProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteDuplicatedProductWaitForPageLoad
		$I->comment("Exiting Action Group [deleteDuplicatedProduct] DeleteAllDuplicateProductUsingProductGridActionGroup");
		$I->comment("Entering Action Group [resetGridToDefaultKeywordSearch] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetGridToDefaultKeywordSearch
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetGridToDefaultKeywordSearchWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetGridToDefaultKeywordSearch
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetGridToDefaultKeywordSearch
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetGridToDefaultKeywordSearchWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetGridToDefaultKeywordSearch
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetGridToDefaultKeywordSearch
		$I->comment("Exiting Action Group [resetGridToDefaultKeywordSearch] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Delete product attributes");
		$I->comment("Delete product attributes");
		$I->comment("Entering Action Group [deleteProductAttribute] AdminDeleteProductAttributeByLabelActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteProductAttribute
		$I->waitForPageLoad(30); // stepKey: waitForProductAttributeGridPageLoadDeleteProductAttribute
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridDeleteProductAttribute
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridDeleteProductAttributeWaitForPageLoad
		$I->fillField("//input[@name='frontend_label']", "Color" . msq("colorProductAttribute")); // stepKey: setAttributeLabelFilterDeleteProductAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeLabelFromTheGridDeleteProductAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeLabelFromTheGridDeleteProductAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteProductAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteProductAttributeWaitForPageLoad
		$I->click("#delete"); // stepKey: clickOnDeleteAttributeButtonDeleteProductAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteAttributeButtonDeleteProductAttributeWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmationPopUpVisibleDeleteProductAttribute
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOnConfirmationButtonDeleteProductAttribute
		$I->waitForPageLoad(60); // stepKey: clickOnConfirmationButtonDeleteProductAttributeWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageVisibleDeleteProductAttribute
		$I->see("You deleted the product attribute.", "#messages div.message-success"); // stepKey: seeAttributeDeleteSuccessMessageDeleteProductAttribute
		$I->comment("Exiting Action Group [deleteProductAttribute] AdminDeleteProductAttributeByLabelActionGroup");
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridFirst
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridFirstWaitForPageLoad
		$I->comment("Entering Action Group [deleteProductSecondAttribute] AdminDeleteProductAttributeByLabelActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteProductSecondAttribute
		$I->waitForPageLoad(30); // stepKey: waitForProductAttributeGridPageLoadDeleteProductSecondAttribute
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridDeleteProductSecondAttribute
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridDeleteProductSecondAttributeWaitForPageLoad
		$I->fillField("//input[@name='frontend_label']", "color" . msq("productAttributeColor")); // stepKey: setAttributeLabelFilterDeleteProductSecondAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeLabelFromTheGridDeleteProductSecondAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeLabelFromTheGridDeleteProductSecondAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteProductSecondAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteProductSecondAttributeWaitForPageLoad
		$I->click("#delete"); // stepKey: clickOnDeleteAttributeButtonDeleteProductSecondAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteAttributeButtonDeleteProductSecondAttributeWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmationPopUpVisibleDeleteProductSecondAttribute
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOnConfirmationButtonDeleteProductSecondAttribute
		$I->waitForPageLoad(60); // stepKey: clickOnConfirmationButtonDeleteProductSecondAttributeWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageVisibleDeleteProductSecondAttribute
		$I->see("You deleted the product attribute.", "#messages div.message-success"); // stepKey: seeAttributeDeleteSuccessMessageDeleteProductSecondAttribute
		$I->comment("Exiting Action Group [deleteProductSecondAttribute] AdminDeleteProductAttributeByLabelActionGroup");
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridSecond
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridSecondWaitForPageLoad
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Duplicate Product"})
	 * @Features({"ConfigurableProduct"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVisibilityOfDuplicateProductTest(AcceptanceTester $I)
	{
		$I->comment("Create attribute and options for product");
		$I->comment("Create attribute and options for product");
		$I->comment("Entering Action Group [navigateToConfigProductPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigProduct', 'id', 'test')); // stepKey: goToProductNavigateToConfigProductPage
		$I->comment("Exiting Action Group [navigateToConfigProductPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->comment("Entering Action Group [addImageForProduct1] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddImageForProduct1
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddImageForProduct1
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddImageForProduct1
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileAddImageForProduct1
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageForProduct1
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddImageForProduct1
		$I->comment("Exiting Action Group [addImageForProduct1] AddProductImageActionGroup");
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
		$I->comment("Entering Action Group [createAttributeForProduct] AdminCreateAttributeFromProductPageWithScopeActionGroup");
		$I->click("#addAttribute"); // stepKey: clickAddAttributeBtnCreateAttributeForProduct
		$I->waitForPageLoad(30); // stepKey: clickAddAttributeBtnCreateAttributeForProductWaitForPageLoad
		$I->waitForText("Select Attribute", 30); // stepKey: checkNewAttributePopUpAppearedCreateAttributeForProduct
		$I->click("//button[@data-index='add_new_attribute_button']"); // stepKey: clickCreateNewAttributeCreateAttributeForProduct
		$I->waitForPageLoad(30); // stepKey: clickCreateNewAttributeCreateAttributeForProductWaitForPageLoad
		$I->waitForElementVisible("//input[@name='frontend_label[0]']", 30); // stepKey: waitForAttrLabelCreateAttributeForProduct
		$I->waitForPageLoad(30); // stepKey: waitForAttrLabelCreateAttributeForProductWaitForPageLoad
		$I->fillField("//input[@name='frontend_label[0]']", "Color" . msq("colorProductAttribute")); // stepKey: fillAttributeLabelCreateAttributeForProduct
		$I->waitForPageLoad(30); // stepKey: fillAttributeLabelCreateAttributeForProductWaitForPageLoad
		$I->selectOption("//select[@name='frontend_input']", "Dropdown"); // stepKey: selectAttributeTypeCreateAttributeForProduct
		$I->waitForPageLoad(30); // stepKey: selectAttributeTypeCreateAttributeForProductWaitForPageLoad
		$I->conditionalClick("div[data-index='advanced_fieldset']", "//div[@data-index='advanced_fieldset']//select[@name='is_global']", false); // stepKey: openAttributeAdvancedSectionCreateAttributeForProduct
		$I->selectOption("//div[@data-index='advanced_fieldset']//select[@name='is_global']", "Global"); // stepKey: selectScopeCreateAttributeForProduct
		$I->click("button#save"); // stepKey: saveAttributeCreateAttributeForProduct
		$I->waitForPageLoad(30); // stepKey: saveAttributeCreateAttributeForProductWaitForPageLoad
		$I->comment("Exiting Action Group [createAttributeForProduct] AdminCreateAttributeFromProductPageWithScopeActionGroup");
		$I->comment("Entering Action Group [reloadPage] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageReloadPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadReloadPage
		$I->comment("Exiting Action Group [reloadPage] ReloadPageActionGroup");
		$I->comment("Replacing reload action and preserve Backward Compatibility");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickOnCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnCreateConfigurationsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilters
		$I->comment("Entering Action Group [createOptions] CreateOptionsForAttributeActionGroup");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickOnFiltersCreateOptions
		$I->fillField(".admin__control-text[name='attribute_code']", "Color" . msq("colorProductAttribute")); // stepKey: fillFilterAttributeCodeFieldCreateOptions
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonCreateOptions
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonCreateOptionsWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxCreateOptions
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButtonCreateOptions
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonCreateOptionsWaitForPageLoad
		$I->waitForElementVisible(".action-create-new", 30); // stepKey: waitCreateNewValueAppearsCreateOptions
		$I->waitForPageLoad(30); // stepKey: waitCreateNewValueAppearsCreateOptionsWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateFirstNewValueCreateOptions
		$I->waitForPageLoad(30); // stepKey: clickOnCreateFirstNewValueCreateOptionsWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "Green" . msq("colorConfigurableProductAttribute1")); // stepKey: fillFieldForNewFirstOptionCreateOptions
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveNewAttributeCreateOptions
		$I->waitForPageLoad(30); // stepKey: clickOnSaveNewAttributeCreateOptionsWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateSecondNewValueCreateOptions
		$I->waitForPageLoad(30); // stepKey: clickOnCreateSecondNewValueCreateOptionsWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "Red" . msq("colorConfigurableProductAttribute2")); // stepKey: fillFieldForNewSecondOptionCreateOptions
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveAttributeCreateOptions
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAttributeCreateOptionsWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllCreateOptions
		$I->comment("Exiting Action Group [createOptions] CreateOptionsForAttributeActionGroup");
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnFirstNextButton
		$I->waitForPageLoad(30); // stepKey: clickOnFirstNextButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForBulkImagesPriceQuantityPageLoad
		$I->comment("Add images to configurable product attribute options");
		$I->comment("Add images to configurable product attribute options");
		$I->comment("Entering Action Group [addImageToConfigurableProductOptionOne] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-images-radio']"); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionOne
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionOneWaitForPageLoad
		$I->selectOption("#apply-images-attributes", "Color" . msq("colorProductAttribute")); // stepKey: selectOptionAddImageToConfigurableProductOptionOne
		$I->waitForPageLoad(30); // stepKey: selectOptionAddImageToConfigurableProductOptionOneWaitForPageLoad
		$I->attachFile("//*[text()='Green" . msq("colorConfigurableProductAttribute1") . "']/../../div[@data-role='gallery']//input[@type='file']", "magento.jpg"); // stepKey: uploadFileAddImageToConfigurableProductOptionOne
		$I->waitForPageLoad(30); // stepKey: uploadFileAddImageToConfigurableProductOptionOneWaitForPageLoad
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageToConfigurableProductOptionOne
		$I->waitForElementVisible("//*[@data-role='gallery']//img[contains(@src, 'magento')]", 30); // stepKey: waitForThumbnailAddImageToConfigurableProductOptionOne
		$I->comment("Exiting Action Group [addImageToConfigurableProductOptionOne] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->comment("Entering Action Group [addImageToConfigurableProductOptionTwo] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-images-radio']"); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionTwo
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImageToConfigurableProductOptionTwoWaitForPageLoad
		$I->selectOption("#apply-images-attributes", "Color" . msq("colorProductAttribute")); // stepKey: selectOptionAddImageToConfigurableProductOptionTwo
		$I->waitForPageLoad(30); // stepKey: selectOptionAddImageToConfigurableProductOptionTwoWaitForPageLoad
		$I->attachFile("//*[text()='Red" . msq("colorConfigurableProductAttribute2") . "']/../../div[@data-role='gallery']//input[@type='file']", "magento-again.jpg"); // stepKey: uploadFileAddImageToConfigurableProductOptionTwo
		$I->waitForPageLoad(30); // stepKey: uploadFileAddImageToConfigurableProductOptionTwoWaitForPageLoad
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageToConfigurableProductOptionTwo
		$I->waitForElementVisible("//*[@data-role='gallery']//img[contains(@src, 'magento-again')]", 30); // stepKey: waitForThumbnailAddImageToConfigurableProductOptionTwo
		$I->comment("Exiting Action Group [addImageToConfigurableProductOptionTwo] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->comment("Add price to product attribute options");
		$I->comment("Add price to product attribute options");
		$I->comment("Entering Action Group [addPriceToConfigurableProductOptionFirst] AddUniquePriceToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-prices-radio']"); // stepKey: clickOnApplyUniquePricesToEachSkuAddPriceToConfigurableProductOptionFirst
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniquePricesToEachSkuAddPriceToConfigurableProductOptionFirstWaitForPageLoad
		$I->selectOption("#select-each-price", "Color" . msq("colorProductAttribute")); // stepKey: selectOptionAddPriceToConfigurableProductOptionFirst
		$I->waitForPageLoad(30); // stepKey: selectOptionAddPriceToConfigurableProductOptionFirstWaitForPageLoad
		$I->fillField("//*[text()='Green" . msq("colorConfigurableProductAttribute1") . "']/../..//input[contains(@id, 'apply-single-price-input')]", "10"); // stepKey: enterAttributeQuantityAddPriceToConfigurableProductOptionFirst
		$I->comment("Exiting Action Group [addPriceToConfigurableProductOptionFirst] AddUniquePriceToConfigurableProductOptionActionGroup");
		$I->comment("Entering Action Group [addPriceToConfigurableProductOptionSecond] AddUniquePriceToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-prices-radio']"); // stepKey: clickOnApplyUniquePricesToEachSkuAddPriceToConfigurableProductOptionSecond
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniquePricesToEachSkuAddPriceToConfigurableProductOptionSecondWaitForPageLoad
		$I->selectOption("#select-each-price", "Color" . msq("colorProductAttribute")); // stepKey: selectOptionAddPriceToConfigurableProductOptionSecond
		$I->waitForPageLoad(30); // stepKey: selectOptionAddPriceToConfigurableProductOptionSecondWaitForPageLoad
		$I->fillField("//*[text()='Red" . msq("colorConfigurableProductAttribute2") . "']/../..//input[contains(@id, 'apply-single-price-input')]", "10"); // stepKey: enterAttributeQuantityAddPriceToConfigurableProductOptionSecond
		$I->comment("Exiting Action Group [addPriceToConfigurableProductOptionSecond] AddUniquePriceToConfigurableProductOptionActionGroup");
		$I->comment("Add quantity to product attribute options");
		$I->comment("Add quantity to product attribute options");
		$I->comment("Entering Action Group [addUniqueQtyForFirstOption] AddUniqueQuantityToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-inventory-radio']"); // stepKey: clickOnApplyUniqueQuantitiesToEachSkuAddUniqueQtyForFirstOption
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniqueQuantitiesToEachSkuAddUniqueQtyForFirstOptionWaitForPageLoad
		$I->selectOption("#apply-single-price-input-qty", "Color" . msq("colorProductAttribute")); // stepKey: selectOptionAddUniqueQtyForFirstOption
		$I->waitForPageLoad(30); // stepKey: selectOptionAddUniqueQtyForFirstOptionWaitForPageLoad
		$I->fillField("//*[text()='Green" . msq("colorConfigurableProductAttribute1") . "']/ancestor::div[contains(@class, 'admin__field _required')]//input[contains(@id, 'apply-qty-input')]", "999"); // stepKey: enterAttributeQuantityAddUniqueQtyForFirstOption
		$I->comment("Exiting Action Group [addUniqueQtyForFirstOption] AddUniqueQuantityToConfigurableProductOptionActionGroup");
		$I->comment("Entering Action Group [addUniqueQtyForSecondOption] AddUniqueQuantityToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-inventory-radio']"); // stepKey: clickOnApplyUniqueQuantitiesToEachSkuAddUniqueQtyForSecondOption
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniqueQuantitiesToEachSkuAddUniqueQtyForSecondOptionWaitForPageLoad
		$I->selectOption("#apply-single-price-input-qty", "Color" . msq("colorProductAttribute")); // stepKey: selectOptionAddUniqueQtyForSecondOption
		$I->waitForPageLoad(30); // stepKey: selectOptionAddUniqueQtyForSecondOptionWaitForPageLoad
		$I->fillField("//*[text()='Red" . msq("colorConfigurableProductAttribute2") . "']/ancestor::div[contains(@class, 'admin__field _required')]//input[contains(@id, 'apply-qty-input')]", "999"); // stepKey: enterAttributeQuantityAddUniqueQtyForSecondOption
		$I->comment("Exiting Action Group [addUniqueQtyForSecondOption] AddUniqueQuantityToConfigurableProductOptionActionGroup");
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnSecondNextButton
		$I->waitForPageLoad(30); // stepKey: clickOnSecondNextButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSummaryPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButtonToGenerateConfigs
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonToGenerateConfigsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForConfigurableProductPageLoad
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
		$I->comment("Duplicate the product");
		$I->comment("Duplicate the product");
		$I->comment("Entering Action Group [saveAndDuplicateProductForm] AdminFormSaveAndDuplicateActionGroup");
		$I->click("button[data-ui-id='save-button-dropdown']"); // stepKey: openSaveDropDownSaveAndDuplicateProductForm
		$I->waitForPageLoad(30); // stepKey: openSaveDropDownSaveAndDuplicateProductFormWaitForPageLoad
		$I->click("span[id='save_and_duplicate']"); // stepKey: clickOnSaveAndDuplicateSaveAndDuplicateProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAndDuplicateSaveAndDuplicateProductFormWaitForPageLoad
		$I->see("You saved the product.", ".message.message-success.success"); // stepKey: assertSaveSuccessSaveAndDuplicateProductForm
		$I->see("You duplicated the product.", ".message.message-success.success"); // stepKey: assertDuplicateSuccessSaveAndDuplicateProductForm
		$I->comment("Exiting Action Group [saveAndDuplicateProductForm] AdminFormSaveAndDuplicateActionGroup");
		$I->click("input[name='product[status]']+label"); // stepKey: clickEnableProduct
		$I->fillField(".admin__field[data-index=name] input", $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "-Updated"); // stepKey: fillProductName
		$I->comment("Entering Action Group [selectInStock] AdminSetStockStatusActionGroup");
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: setStockStatusSelectInStock
		$I->waitForPageLoad(30); // stepKey: setStockStatusSelectInStockWaitForPageLoad
		$I->comment("Exiting Action Group [selectInStock] AdminSetStockStatusActionGroup");
		$I->comment("Change product image");
		$I->comment("Change product image");
		$I->comment("Entering Action Group [removeProductImage] RemoveProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionRemoveProductImage
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshRemoveProductImage
		$I->click(".action-remove"); // stepKey: clickRemoveImageRemoveProductImage
		$I->comment("Exiting Action Group [removeProductImage] RemoveProductImageActionGroup");
		$I->comment("Entering Action Group [addImageForProduct] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddImageForProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddImageForProduct
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddImageForProduct
		$I->attachFile("#fileupload", "adobe-base.jpg"); // stepKey: uploadFileAddImageForProduct
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageForProduct
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", 30); // stepKey: waitForThumbnailAddImageForProduct
		$I->comment("Exiting Action Group [addImageForProduct] AddProductImageActionGroup");
		$I->comment("Disable configurations");
		$I->comment("Disable configurations");
		$I->comment("Entering Action Group [disableFirstConfig] AdminConfigurableProductDisableConfigurationsActionGroup");
		$I->click("//*[.='Attributes']/ancestor::tr/td[@data-index='attributes']//span[contains(text(), 'Green" . msq("colorConfigurableProductAttribute1") . "')]/ancestor::tr//button[@class='action-select']"); // stepKey: clickToExpandActionsSelectDisableFirstConfig
		$I->click("//a[text()='Disable Product']"); // stepKey: clickDisableChildProductDisableFirstConfig
		$I->see("Disabled", "//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Green" . msq("colorConfigurableProductAttribute1") . "')]/ancestor::tr/td[@data-index='status']"); // stepKey: seeConfigDisabledDisableFirstConfig
		$I->comment("Exiting Action Group [disableFirstConfig] AdminConfigurableProductDisableConfigurationsActionGroup");
		$I->comment("Entering Action Group [disableSecondConfig] AdminConfigurableProductDisableConfigurationsActionGroup");
		$I->click("//*[.='Attributes']/ancestor::tr/td[@data-index='attributes']//span[contains(text(), 'Red" . msq("colorConfigurableProductAttribute2") . "')]/ancestor::tr//button[@class='action-select']"); // stepKey: clickToExpandActionsSelectDisableSecondConfig
		$I->click("//a[text()='Disable Product']"); // stepKey: clickDisableChildProductDisableSecondConfig
		$I->see("Disabled", "//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Red" . msq("colorConfigurableProductAttribute2") . "')]/ancestor::tr/td[@data-index='status']"); // stepKey: seeConfigDisabledDisableSecondConfig
		$I->comment("Exiting Action Group [disableSecondConfig] AdminConfigurableProductDisableConfigurationsActionGroup");
		$I->comment("Entering Action Group [saveDuplicatedProductForm] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveDuplicatedProductForm
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveDuplicatedProductForm
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveDuplicatedProductFormWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveDuplicatedProductForm
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveDuplicatedProductFormWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveDuplicatedProductForm
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveDuplicatedProductForm
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveDuplicatedProductForm
		$I->comment("Exiting Action Group [saveDuplicatedProductForm] SaveProductFormActionGroup");
		$I->comment("Create new configurations with another attribute");
		$I->comment("Create new configurations with another attribute");
		$I->comment("Entering Action Group [createAttributeForDuplicatedProduct] AdminCreateAttributeFromProductPageWithScopeActionGroup");
		$I->click("#addAttribute"); // stepKey: clickAddAttributeBtnCreateAttributeForDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickAddAttributeBtnCreateAttributeForDuplicatedProductWaitForPageLoad
		$I->waitForText("Select Attribute", 30); // stepKey: checkNewAttributePopUpAppearedCreateAttributeForDuplicatedProduct
		$I->click("//button[@data-index='add_new_attribute_button']"); // stepKey: clickCreateNewAttributeCreateAttributeForDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickCreateNewAttributeCreateAttributeForDuplicatedProductWaitForPageLoad
		$I->waitForElementVisible("//input[@name='frontend_label[0]']", 30); // stepKey: waitForAttrLabelCreateAttributeForDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: waitForAttrLabelCreateAttributeForDuplicatedProductWaitForPageLoad
		$I->fillField("//input[@name='frontend_label[0]']", "color" . msq("productAttributeColor")); // stepKey: fillAttributeLabelCreateAttributeForDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: fillAttributeLabelCreateAttributeForDuplicatedProductWaitForPageLoad
		$I->selectOption("//select[@name='frontend_input']", "Dropdown"); // stepKey: selectAttributeTypeCreateAttributeForDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: selectAttributeTypeCreateAttributeForDuplicatedProductWaitForPageLoad
		$I->conditionalClick("div[data-index='advanced_fieldset']", "//div[@data-index='advanced_fieldset']//select[@name='is_global']", false); // stepKey: openAttributeAdvancedSectionCreateAttributeForDuplicatedProduct
		$I->selectOption("//div[@data-index='advanced_fieldset']//select[@name='is_global']", "Global"); // stepKey: selectScopeCreateAttributeForDuplicatedProduct
		$I->click("button#save"); // stepKey: saveAttributeCreateAttributeForDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: saveAttributeCreateAttributeForDuplicatedProductWaitForPageLoad
		$I->comment("Exiting Action Group [createAttributeForDuplicatedProduct] AdminCreateAttributeFromProductPageWithScopeActionGroup");
		$I->comment("Entering Action Group [reloadDuplicatedProductPage] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageReloadDuplicatedProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadReloadDuplicatedProductPage
		$I->comment("Exiting Action Group [reloadDuplicatedProductPage] ReloadPageActionGroup");
		$I->comment("Replacing reload action and preserve Backward Compatibility");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: createConfigurationsDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: createConfigurationsDuplicatedProductWaitForPageLoad
		$I->waitForElementVisible("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", 30); // stepKey: waitForCreateConfigurationsPageLoad
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdown
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Deselect All']"); // stepKey: DeselectAllAttributes
		$I->comment("Entering Action Group [createOptionsForDuplicatedProduct] CreateOptionsForAttributeActionGroup");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickOnFiltersCreateOptionsForDuplicatedProduct
		$I->fillField(".admin__control-text[name='attribute_code']", "color" . msq("productAttributeColor")); // stepKey: fillFilterAttributeCodeFieldCreateOptionsForDuplicatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonCreateOptionsForDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonCreateOptionsForDuplicatedProductWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxCreateOptionsForDuplicatedProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButtonCreateOptionsForDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonCreateOptionsForDuplicatedProductWaitForPageLoad
		$I->waitForElementVisible(".action-create-new", 30); // stepKey: waitCreateNewValueAppearsCreateOptionsForDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: waitCreateNewValueAppearsCreateOptionsForDuplicatedProductWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateFirstNewValueCreateOptionsForDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickOnCreateFirstNewValueCreateOptionsForDuplicatedProductWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "Green" . msq("colorConfigurableProductAttribute1")); // stepKey: fillFieldForNewFirstOptionCreateOptionsForDuplicatedProduct
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveNewAttributeCreateOptionsForDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSaveNewAttributeCreateOptionsForDuplicatedProductWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateSecondNewValueCreateOptionsForDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickOnCreateSecondNewValueCreateOptionsForDuplicatedProductWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "Red" . msq("colorConfigurableProductAttribute2")); // stepKey: fillFieldForNewSecondOptionCreateOptionsForDuplicatedProduct
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveAttributeCreateOptionsForDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAttributeCreateOptionsForDuplicatedProductWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllCreateOptionsForDuplicatedProduct
		$I->comment("Exiting Action Group [createOptionsForDuplicatedProduct] CreateOptionsForAttributeActionGroup");
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnFirstNextButtonForDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickOnFirstNextButtonForDuplicatedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForBulkImagesPriceQuantityPageLoadForDuplicatedProduct
		$I->comment("Entering Action Group [addImgConfigProductOption1DuplicatedProduct] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-images-radio']"); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImgConfigProductOption1DuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImgConfigProductOption1DuplicatedProductWaitForPageLoad
		$I->selectOption("#apply-images-attributes", "color" . msq("productAttributeColor")); // stepKey: selectOptionAddImgConfigProductOption1DuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: selectOptionAddImgConfigProductOption1DuplicatedProductWaitForPageLoad
		$I->attachFile("//*[text()='Green" . msq("colorConfigurableProductAttribute1") . "']/../../div[@data-role='gallery']//input[@type='file']", "magento-logo.png"); // stepKey: uploadFileAddImgConfigProductOption1DuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: uploadFileAddImgConfigProductOption1DuplicatedProductWaitForPageLoad
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImgConfigProductOption1DuplicatedProduct
		$I->waitForElementVisible("//*[@data-role='gallery']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddImgConfigProductOption1DuplicatedProduct
		$I->comment("Exiting Action Group [addImgConfigProductOption1DuplicatedProduct] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->comment("Entering Action Group [addImgConfigProductOption2DuplicatedProduct] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-images-radio']"); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImgConfigProductOption2DuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniqueImagesToEachSkuAddImgConfigProductOption2DuplicatedProductWaitForPageLoad
		$I->selectOption("#apply-images-attributes", "color" . msq("productAttributeColor")); // stepKey: selectOptionAddImgConfigProductOption2DuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: selectOptionAddImgConfigProductOption2DuplicatedProductWaitForPageLoad
		$I->attachFile("//*[text()='Red" . msq("colorConfigurableProductAttribute2") . "']/../../div[@data-role='gallery']//input[@type='file']", "magento-logo.png"); // stepKey: uploadFileAddImgConfigProductOption2DuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: uploadFileAddImgConfigProductOption2DuplicatedProductWaitForPageLoad
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImgConfigProductOption2DuplicatedProduct
		$I->waitForElementVisible("//*[@data-role='gallery']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddImgConfigProductOption2DuplicatedProduct
		$I->comment("Exiting Action Group [addImgConfigProductOption2DuplicatedProduct] AddUniqueImageToConfigurableProductOptionActionGroup");
		$I->comment("Entering Action Group [addPriceConfigProductOption1DuplicatedProduct] AddUniquePriceToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-prices-radio']"); // stepKey: clickOnApplyUniquePricesToEachSkuAddPriceConfigProductOption1DuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniquePricesToEachSkuAddPriceConfigProductOption1DuplicatedProductWaitForPageLoad
		$I->selectOption("#select-each-price", "color" . msq("productAttributeColor")); // stepKey: selectOptionAddPriceConfigProductOption1DuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: selectOptionAddPriceConfigProductOption1DuplicatedProductWaitForPageLoad
		$I->fillField("//*[text()='Green" . msq("colorConfigurableProductAttribute1") . "']/../..//input[contains(@id, 'apply-single-price-input')]", "10"); // stepKey: enterAttributeQuantityAddPriceConfigProductOption1DuplicatedProduct
		$I->comment("Exiting Action Group [addPriceConfigProductOption1DuplicatedProduct] AddUniquePriceToConfigurableProductOptionActionGroup");
		$I->comment("Entering Action Group [addPriceConfigProductOption2DuplicatedProduct] AddUniquePriceToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-prices-radio']"); // stepKey: clickOnApplyUniquePricesToEachSkuAddPriceConfigProductOption2DuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniquePricesToEachSkuAddPriceConfigProductOption2DuplicatedProductWaitForPageLoad
		$I->selectOption("#select-each-price", "color" . msq("productAttributeColor")); // stepKey: selectOptionAddPriceConfigProductOption2DuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: selectOptionAddPriceConfigProductOption2DuplicatedProductWaitForPageLoad
		$I->fillField("//*[text()='Red" . msq("colorConfigurableProductAttribute2") . "']/../..//input[contains(@id, 'apply-single-price-input')]", "10"); // stepKey: enterAttributeQuantityAddPriceConfigProductOption2DuplicatedProduct
		$I->comment("Exiting Action Group [addPriceConfigProductOption2DuplicatedProduct] AddUniquePriceToConfigurableProductOptionActionGroup");
		$I->comment("Entering Action Group [addUniqueQtyOption1DuplicatedProduct] AddUniqueQuantityToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-inventory-radio']"); // stepKey: clickOnApplyUniqueQuantitiesToEachSkuAddUniqueQtyOption1DuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniqueQuantitiesToEachSkuAddUniqueQtyOption1DuplicatedProductWaitForPageLoad
		$I->selectOption("#apply-single-price-input-qty", "color" . msq("productAttributeColor")); // stepKey: selectOptionAddUniqueQtyOption1DuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: selectOptionAddUniqueQtyOption1DuplicatedProductWaitForPageLoad
		$I->fillField("//*[text()='Green" . msq("colorConfigurableProductAttribute1") . "']/ancestor::div[contains(@class, 'admin__field _required')]//input[contains(@id, 'apply-qty-input')]", "999"); // stepKey: enterAttributeQuantityAddUniqueQtyOption1DuplicatedProduct
		$I->comment("Exiting Action Group [addUniqueQtyOption1DuplicatedProduct] AddUniqueQuantityToConfigurableProductOptionActionGroup");
		$I->comment("Entering Action Group [addUniqueQtyOption2DuplicatedProduct] AddUniqueQuantityToConfigurableProductOptionActionGroup");
		$I->click(".admin__field-label[for='apply-unique-inventory-radio']"); // stepKey: clickOnApplyUniqueQuantitiesToEachSkuAddUniqueQtyOption2DuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickOnApplyUniqueQuantitiesToEachSkuAddUniqueQtyOption2DuplicatedProductWaitForPageLoad
		$I->selectOption("#apply-single-price-input-qty", "color" . msq("productAttributeColor")); // stepKey: selectOptionAddUniqueQtyOption2DuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: selectOptionAddUniqueQtyOption2DuplicatedProductWaitForPageLoad
		$I->fillField("//*[text()='Red" . msq("colorConfigurableProductAttribute2") . "']/ancestor::div[contains(@class, 'admin__field _required')]//input[contains(@id, 'apply-qty-input')]", "999"); // stepKey: enterAttributeQuantityAddUniqueQtyOption2DuplicatedProduct
		$I->comment("Exiting Action Group [addUniqueQtyOption2DuplicatedProduct] AddUniqueQuantityToConfigurableProductOptionActionGroup");
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOn2NextButtonForDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickOn2NextButtonForDuplicatedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSummaryPageLoadForDuplicatedProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: generateConfigsForDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: generateConfigsForDuplicatedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDuplicatedProductPageLoad
		$I->comment("Entering Action Group [saveDuplicatedProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveDuplicatedProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveDuplicatedProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveDuplicatedProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveDuplicatedProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveDuplicatedProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveDuplicatedProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveDuplicatedProduct
		$I->comment("Exiting Action Group [saveDuplicatedProduct] SaveProductFormActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Assert configurable product in category");
		$I->comment("Assert configurable product in category");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onStorefrontCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoad
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "-Updated')]"); // stepKey: assertProductNameInCategoryPage
		$I->comment("Assert product options in Storefront product page");
		$I->comment("Assert product options in Storefront product page");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . "-1.html"); // stepKey: amOnSimpleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOnStorefront
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test') . "-Updated", ".base"); // stepKey: seeConfigurableProductName
		$I->see("color" . msq("productAttributeColor"), "#product-options-wrapper div[tabindex='0'] label"); // stepKey: seeColorAttributeName
		$I->selectOption("#product-options-wrapper .super-attribute-select", "Green" . msq("colorConfigurableProductAttribute1")); // stepKey: selectFirstOption
		$I->see("10", "div.price-box.price-final_price"); // stepKey: assertFirstOptionProductPrice
		$I->seeElement("//*[@class='product media']//img[contains(@src, 'magento-logo')]"); // stepKey: seeFirstImage
		$I->selectOption("#product-options-wrapper .super-attribute-select", "Green" . msq("colorConfigurableProductAttribute1")); // stepKey: selectSecondOption
		$I->see("10", "div.price-box.price-final_price"); // stepKey: seeSecondOptionProductPrice
		$I->seeElement("//*[@class='product media']//img[contains(@src, 'magento-logo')]"); // stepKey: seeSecondImage
	}
}
