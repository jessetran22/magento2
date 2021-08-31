<?php
namespace Magento\AcceptanceTest\_RemoteStorageAwsS3EnabledSuite\Backend;

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
 * @group wishlist
 * @group remote_storage_aws_s3
 * @Title("MC-38708: AWS S3 when user add Configurable child product to WIshlist then child product image should be shown in Wishlist")
 * @Description("When user add Configurable child product to WIshlist then child product image should be shown in Wishlist<h3>Test files</h3>app/code/Magento/AwsS3/Test/Mftf/Test/AwsS3ConfigurableProductChildImageShouldBeShownOnWishListTest.xml<br>")
 * @TestCaseId("MC-38708")
 */
class AwsS3ConfigurableProductChildImageShouldBeShownOnWishListTestCest
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
        $this->helperContainer->create("\Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions");
        $this->helperContainer->create("Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Tax\Test\Mftf\Helper\TaxHelpers");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$setProductImageSettingUnderCofigurationSalesCheckout = $I->magentoCLI("config:set checkout/cart/configurable_product_image 0", 60); // stepKey: setProductImageSettingUnderCofigurationSalesCheckout
		$I->comment($setProductImageSettingUnderCofigurationSalesCheckout);
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->comment("Entering Action Group [createProduct] CreateConfigurableProductActionGroup");
		$I->comment("fill in basic configurable product values");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: amOnProductGridPageCreateProduct
		$I->waitForPageLoad(30); // stepKey: wait1CreateProduct
		$I->click(".action-toggle.primary.add"); // stepKey: clickOnAddProductToggleCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnAddProductToggleCreateProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-configurable']"); // stepKey: clickOnAddConfigurableProductCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnAddConfigurableProductCreateProductWaitForPageLoad
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillNameCreateProduct
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillSKUCreateProduct
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillPriceCreateProduct
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillQuantityCreateProduct
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'hook')]); // stepKey: fillCategoryCreateProduct
		$I->waitForPageLoad(30); // stepKey: fillCategoryCreateProductWaitForPageLoad
		$I->selectOption("//select[@name='product[visibility]']", "4"); // stepKey: fillVisibilityCreateProduct
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSectionCreateProduct
		$I->waitForPageLoad(30); // stepKey: openSeoSectionCreateProductWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "testproductname" . msq("_defaultProduct")); // stepKey: fillUrlKeyCreateProduct
		$I->comment("create configurations for colors the product is available in");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickOnCreateConfigurationsCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnCreateConfigurationsCreateProductWaitForPageLoad
		$I->click(".select-attributes-actions button[title='Create New Attribute']"); // stepKey: clickOnNewAttributeCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNewAttributeCreateProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForIFrameCreateProduct
		$I->switchToIFrame("create_new_attribute_container"); // stepKey: switchToNewAttributeIFrameCreateProduct
		$I->fillField("input[name='frontend_label[0]']", "Color" . msq("colorProductAttribute")); // stepKey: fillDefaultLabelCreateProduct
		$I->click("#save"); // stepKey: clickOnNewAttributePanelCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveAttributeCreateProduct
		$I->switchToIFrame(); // stepKey: switchOutOfIFrameCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitForFiltersCreateProduct
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickOnFiltersCreateProduct
		$I->fillField(".admin__control-text[name='attribute_code']", "Color" . msq("colorProductAttribute")); // stepKey: fillFilterAttributeCodeFieldCreateProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonCreateProductWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxCreateProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1CreateProductWaitForPageLoad
		$I->waitForElementVisible(".action-create-new", 30); // stepKey: waitCreateNewValueAppearsCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitCreateNewValueAppearsCreateProductWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateNewValue1CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnCreateNewValue1CreateProductWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "White" . msq("colorProductAttribute1")); // stepKey: fillFieldForNewAttribute1CreateProduct
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveNewAttribute1CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSaveNewAttribute1CreateProductWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateNewValue2CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnCreateNewValue2CreateProductWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "Red" . msq("colorProductAttribute2")); // stepKey: fillFieldForNewAttribute2CreateProduct
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveNewAttribute2CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSaveNewAttribute2CreateProductWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateNewValue3CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnCreateNewValue3CreateProductWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "Blue" . msq("colorProductAttribute3")); // stepKey: fillFieldForNewAttribute3CreateProduct
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveNewAttribute3CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSaveNewAttribute3CreateProductWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllCreateProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2CreateProductWaitForPageLoad
		$I->click(".admin__field-label[for='apply-unique-prices-radio']"); // stepKey: clickOnApplyUniquePricesByAttributeToEachSkuCreateProduct
		$I->selectOption("#select-each-price", "Color" . msq("colorProductAttribute")); // stepKey: selectAttributesCreateProduct
		$I->waitForPageLoad(30); // stepKey: selectAttributesCreateProductWaitForPageLoad
		$I->fillField("#apply-single-price-input-0", "1.00"); // stepKey: fillAttributePrice1CreateProduct
		$I->fillField("#apply-single-price-input-1", "2.00"); // stepKey: fillAttributePrice2CreateProduct
		$I->fillField("#apply-single-price-input-2", "3.00"); // stepKey: fillAttributePrice3CreateProduct
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuCreateProductWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "1"); // stepKey: enterAttributeQuantityCreateProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3CreateProductWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4CreateProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButton2CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButton2CreateProductWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmInPopupCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupCreateProductWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessageCreateProduct
		$I->seeInTitle("testProductName" . msq("_defaultProduct")); // stepKey: seeProductNameInTitleCreateProduct
		$I->comment("Exiting Action Group [createProduct] CreateConfigurableProductActionGroup");
		$I->createEntity("customer", "hook", "Simple_US_Customer", [], []); // stepKey: customer
		$I->comment("BIC workaround");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageOpenProductIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadOpenProductIndexPage
		$I->comment("Exiting Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [clearGridFiltersConfigurable] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClearGridFiltersConfigurable
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersClearGridFiltersConfigurable
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetClearGridFiltersConfigurable
		$I->comment("Exiting Action Group [clearGridFiltersConfigurable] AdminGridFilterResetActionGroup");
		$I->comment("Entering Action Group [addSkuFilterConfigurable] AdminGridFilterFillInputFieldActionGroup");
		$I->conditionalClick("//div[@class='admin__data-grid-header'][(not(ancestor::*[@class='sticky-header']) and not(contains(@style,'visibility: hidden'))) or (ancestor::*[@class='sticky-header' and not(contains(@style,'display: none'))])]//button[@data-action='grid-filter-expand']", "[data-part='filter-form']", false); // stepKey: openFiltersFormIfNecessaryAddSkuFilterConfigurable
		$I->waitForElementVisible("[data-part='filter-form']", 30); // stepKey: waitForFormVisibleAddSkuFilterConfigurable
		$I->fillField("//*[@data-part='filter-form']//input[@name='sku']", "testSku" . msq("_defaultProduct")); // stepKey: fillFilterInputFieldAddSkuFilterConfigurable
		$I->comment("Exiting Action Group [addSkuFilterConfigurable] AdminGridFilterFillInputFieldActionGroup");
		$I->comment("Entering Action Group [addTypeFilterConfigurable] AdminGridFilterFillSelectFieldActionGroup");
		$I->selectOption("//*[@data-part='filter-form']//select[@name='type_id']", "Configurable Product"); // stepKey: selectOptionAddTypeFilterConfigurable
		$I->comment("Exiting Action Group [addTypeFilterConfigurable] AdminGridFilterFillSelectFieldActionGroup");
		$I->comment("Entering Action Group [applyGridFilterConfigurable] AdminClickSearchInGridActionGroup");
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchApplyGridFilterConfigurable
		$I->waitForPageLoad(30); // stepKey: clickSearchApplyGridFilterConfigurableWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultApplyGridFilterConfigurable
		$I->comment("Exiting Action Group [applyGridFilterConfigurable] AdminClickSearchInGridActionGroup");
		$I->comment("Entering Action Group [deleteConfigurableProduct] DeleteProductsIfTheyExistActionGroup");
		$I->conditionalClick("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", "table.data-grid tr.data-row:first-of-type", true); // stepKey: openMulticheckDropdownDeleteConfigurableProduct
		$I->conditionalClick("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']", "table.data-grid tr.data-row:first-of-type", true); // stepKey: selectAllProductInFilteredGridDeleteConfigurableProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteConfigurableProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteConfigurableProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm button.action-accept", 30); // stepKey: waitForModalPopUpDeleteConfigurableProduct
		$I->waitForPageLoad(60); // stepKey: waitForModalPopUpDeleteConfigurableProductWaitForPageLoad
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteConfigurableProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteConfigurableProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadDeleteConfigurableProduct
		$I->comment("Exiting Action Group [deleteConfigurableProduct] DeleteProductsIfTheyExistActionGroup");
		$I->comment("Entering Action Group [clearGridFiltersVirtual] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClearGridFiltersVirtual
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersClearGridFiltersVirtual
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetClearGridFiltersVirtual
		$I->comment("Exiting Action Group [clearGridFiltersVirtual] AdminGridFilterResetActionGroup");
		$I->comment("Entering Action Group [addSkuFilterVirtual] AdminGridFilterFillInputFieldActionGroup");
		$I->conditionalClick("//div[@class='admin__data-grid-header'][(not(ancestor::*[@class='sticky-header']) and not(contains(@style,'visibility: hidden'))) or (ancestor::*[@class='sticky-header' and not(contains(@style,'display: none'))])]//button[@data-action='grid-filter-expand']", "[data-part='filter-form']", false); // stepKey: openFiltersFormIfNecessaryAddSkuFilterVirtual
		$I->waitForElementVisible("[data-part='filter-form']", 30); // stepKey: waitForFormVisibleAddSkuFilterVirtual
		$I->fillField("//*[@data-part='filter-form']//input[@name='sku']", "testSku" . msq("_defaultProduct")); // stepKey: fillFilterInputFieldAddSkuFilterVirtual
		$I->comment("Exiting Action Group [addSkuFilterVirtual] AdminGridFilterFillInputFieldActionGroup");
		$I->comment("Entering Action Group [applyGridFilterVirtual] AdminClickSearchInGridActionGroup");
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchApplyGridFilterVirtual
		$I->waitForPageLoad(30); // stepKey: clickSearchApplyGridFilterVirtualWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultApplyGridFilterVirtual
		$I->comment("Exiting Action Group [applyGridFilterVirtual] AdminClickSearchInGridActionGroup");
		$I->comment("Entering Action Group [deleteVirtualProducts] DeleteProductsIfTheyExistActionGroup");
		$I->conditionalClick("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", "table.data-grid tr.data-row:first-of-type", true); // stepKey: openMulticheckDropdownDeleteVirtualProducts
		$I->conditionalClick("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']", "table.data-grid tr.data-row:first-of-type", true); // stepKey: selectAllProductInFilteredGridDeleteVirtualProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteVirtualProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteVirtualProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteVirtualProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteVirtualProductsWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm button.action-accept", 30); // stepKey: waitForModalPopUpDeleteVirtualProducts
		$I->waitForPageLoad(60); // stepKey: waitForModalPopUpDeleteVirtualProductsWaitForPageLoad
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteVirtualProducts
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteVirtualProductsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadDeleteVirtualProducts
		$I->comment("Exiting Action Group [deleteVirtualProducts] DeleteProductsIfTheyExistActionGroup");
		$I->comment("Entering Action Group [resetProductGrid] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductGridWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetProductGrid
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetProductGrid
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetProductGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetProductGrid
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetProductGrid
		$I->comment("Exiting Action Group [resetProductGrid] ResetProductGridToDefaultViewActionGroup");
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$I->comment("BIC workaround");
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
	 * @Features({"AwsS3"})
	 * @Stories({"Configurable product child image should be Shown on wishlist"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AwsS3ConfigurableProductChildImageShouldBeShownOnWishListTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetFiltersIfPresent] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetFiltersIfPresent
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetFiltersIfPresentWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetFiltersIfPresent
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetFiltersIfPresent
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetFiltersIfPresentWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetFiltersIfPresent
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetFiltersIfPresent
		$I->comment("Exiting Action Group [resetFiltersIfPresent] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [searchProductGrid] SearchProductGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialSearchProductGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialSearchProductGridWaitForPageLoad
		$I->fillField("input#fulltext", "testProductName" . msq("_defaultProduct")); // stepKey: fillKeywordSearchFieldSearchProductGrid
		$I->click(".data-grid-search-control-wrap button.action-submit"); // stepKey: clickKeywordSearchSearchProductGrid
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchProductGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSearchSearchProductGrid
		$I->comment("Exiting Action Group [searchProductGrid] SearchProductGridByKeywordActionGroup");
		$I->click("//td/div[text()='testProductName" . msq("_defaultProduct") . "']"); // stepKey: selectProductToAddImage
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoad
		$I->comment("Entering Action Group [addImageForParentProduct] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddImageForParentProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddImageForParentProduct
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddImageForParentProduct
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileAddImageForParentProduct
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageForParentProduct
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddImageForParentProduct
		$I->comment("Exiting Action Group [addImageForParentProduct] AddProductImageActionGroup");
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
		$I->comment("Entering Action Group [navigateToProductIndex1] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex1
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex1
		$I->comment("Exiting Action Group [navigateToProductIndex1] AdminOpenProductIndexPageActionGroup");
		$I->click("//td/div[text()='White" . msq("colorProductAttribute1") . "']"); // stepKey: selectProductToAddImage1
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoad1
		$I->comment("Entering Action Group [addImageForChildProduct] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddImageForChildProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddImageForChildProduct
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddImageForChildProduct
		$I->attachFile("#fileupload", "magento-again.jpg"); // stepKey: uploadFileAddImageForChildProduct
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageForChildProduct
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]", 30); // stepKey: waitForThumbnailAddImageForChildProduct
		$I->comment("Exiting Action Group [addImageForChildProduct] AddProductImageActionGroup");
		$I->comment("Entering Action Group [saveSimpleProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveSimpleProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveSimpleProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveSimpleProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveSimpleProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveSimpleProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveSimpleProduct
		$I->comment("Exiting Action Group [saveSimpleProduct] SaveProductFormActionGroup");
		$I->comment("Sign in as customer");
		$I->comment("Entering Action Group [goToSignInPage] StorefrontOpenCustomerLoginPageActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageGoToSignInPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToSignInPage
		$I->comment("Exiting Action Group [goToSignInPage] StorefrontOpenCustomerLoginPageActionGroup");
		$I->comment("Entering Action Group [fillLoginFormWithCorrectCredentials] StorefrontFillCustomerLoginFormActionGroup");
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailFillLoginFormWithCorrectCredentials
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillPasswordFillLoginFormWithCorrectCredentials
		$I->comment("Exiting Action Group [fillLoginFormWithCorrectCredentials] StorefrontFillCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [clickSignInAccountButton] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->click("#send2"); // stepKey: clickSignInButtonClickSignInAccountButton
		$I->waitForPageLoad(30); // stepKey: clickSignInButtonClickSignInAccountButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSignInClickSignInAccountButton
		$I->comment("Exiting Action Group [clickSignInAccountButton] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->see($I->retrieveEntityField('customer', 'firstname', 'test'), ".box.box-information .box-content"); // stepKey: seeFirstName
		$I->see($I->retrieveEntityField('customer', 'lastname', 'test'), ".box.box-information .box-content"); // stepKey: seeLastName
		$I->see($I->retrieveEntityField('customer', 'email', 'test'), ".box.box-information .box-content"); // stepKey: seeEmail
		$I->waitForPageLoad(30); // stepKey: waitForLogin
		$I->amOnPage("testproductname" . msq("_defaultProduct") . ".html"); // stepKey: amOnConfigurableProductPage
		$I->waitForPageLoad(30); // stepKey: wait3
		$I->see("testProductName" . msq("_defaultProduct"), ".base"); // stepKey: seeProductName
		$I->selectOption("#product-options-wrapper .super-attribute-select", "White" . msq("colorProductAttribute1")); // stepKey: selectOption1
		$I->waitForElementVisible("button#product-addtocart-button", 30); // stepKey: waitForAddToCartVisible
		$I->click("//a[@class='action towishlist']"); // stepKey: addFirstProductToWishlist
		$I->waitForPageLoad(30); // stepKey: addFirstProductToWishlistWaitForPageLoad
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: addProductToWishlistWaitForSuccessMessage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad2
		$I->seeElement("//main//li//a//img[contains(@src, 'magento-again')]"); // stepKey: AssertWishlistProductImage
		$I->seeElement("//main//ol[@id='wishlist-sidebar']//a//img[contains(@src, 'magento-again')]"); // stepKey: AssertWishlistSidebarProductImage
	}
}
