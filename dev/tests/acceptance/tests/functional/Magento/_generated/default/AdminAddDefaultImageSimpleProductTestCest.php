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
 * @Title("MC-113: Storefront Fotorama arrows test")
 * @Description("Check arrows next to the thumbs are not visible than there is room for all pictures.<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminAddDefaultImageSimpleProductTest.xml<br>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontFotoramaArrowsTest.xml<br>")
 * @TestCaseId("MC-113")
 * @group Catalog
 */
class AdminAddDefaultImageSimpleProductTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Features({"Catalog"})
	 * @Stories({"Add/remove images and videos for all product types and category"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAddDefaultImageSimpleProductTest(AcceptanceTester $I)
	{
		$I->comment("Create product");
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetProductGridColumnsInitial] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductGridColumnsInitial
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductGridColumnsInitialWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetProductGridColumnsInitial
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetProductGridColumnsInitial
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetProductGridColumnsInitialWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetProductGridColumnsInitial
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetProductGridColumnsInitial
		$I->comment("Exiting Action Group [resetProductGridColumnsInitial] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [goToCreateSimpleProduct] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleGoToCreateSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleGoToCreateSimpleProductWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-simple']", 30); // stepKey: waitForAddProductDropdownGoToCreateSimpleProduct
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddProductTypeGoToCreateSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadGoToCreateSimpleProduct
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: seeNewProductUrlGoToCreateSimpleProduct
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleGoToCreateSimpleProduct
		$I->comment("Exiting Action Group [goToCreateSimpleProduct] GoToCreateProductPageActionGroup");
		$I->comment("Entering Action Group [fillSimpleProductMain] FillMainProductFormNoWeightActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "Simple Product 3 " . msq("SimpleProduct3")); // stepKey: fillProductNameFillSimpleProductMain
		$I->fillField(".admin__field[data-index=sku] input", "SimpleProduct3" . msq("SimpleProduct3")); // stepKey: fillProductSkuFillSimpleProductMain
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillSimpleProductMain
		$I->fillField(".admin__field[data-index=qty] input", "1000"); // stepKey: fillProductQtyFillSimpleProductMain
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillSimpleProductMain
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillSimpleProductMainWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has no weight"); // stepKey: selectWeightFillSimpleProductMain
		$I->comment("Exiting Action Group [fillSimpleProductMain] FillMainProductFormNoWeightActionGroup");
		$I->comment("Add image to product");
		$I->comment("Entering Action Group [addImageForProductSimple] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddImageForProductSimple
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddImageForProductSimple
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddImageForProductSimple
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileAddImageForProductSimple
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageForProductSimple
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddImageForProductSimple
		$I->comment("Exiting Action Group [addImageForProductSimple] AddProductImageActionGroup");
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
		$I->comment("Assert product image in admin product form");
		$I->comment("Entering Action Group [assertProductImageAdminProductPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProductImageAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProductImageAdminProductPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: seeImageAssertProductImageAdminProductPage
		$I->comment("Exiting Action Group [assertProductImageAdminProductPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->comment("Assert product in storefront product page");
		$I->comment("Entering Action Group [AssertProductInStorefrontProductPage] AssertProductInStorefrontProductPageActionGroup");
		$I->comment("Go to storefront product page, assert product name, sku and price");
		$I->amOnPage("simple-product-3-" . msq("SimpleProduct3") . ".html"); // stepKey: navigateToProductPageAssertProductInStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssertProductInStorefrontProductPage
		$I->seeInTitle("Simple Product 3 " . msq("SimpleProduct3")); // stepKey: assertProductNameTitleAssertProductInStorefrontProductPage
		$I->see("Simple Product 3 " . msq("SimpleProduct3"), ".base"); // stepKey: assertProductNameAssertProductInStorefrontProductPage
		$I->see("123.00", "div.price-box.price-final_price"); // stepKey: assertProductPriceAssertProductInStorefrontProductPage
		$I->see("SimpleProduct3" . msq("SimpleProduct3"), ".product.attribute.sku>.value"); // stepKey: assertProductSkuAssertProductInStorefrontProductPage
		$I->comment("Exiting Action Group [AssertProductInStorefrontProductPage] AssertProductInStorefrontProductPageActionGroup");
		$I->comment("Assert product image in storefront product page");
		$I->comment("Entering Action Group [assertProductImageStorefrontProductPage] AssertProductImageStorefrontProductPageActionGroup");
		$I->seeInCurrentUrl("/simple-product-3-" . msq("SimpleProduct3") . ".html"); // stepKey: checkUrlAssertProductImageStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProductImageStorefrontProductPage
		$I->seeElement("//*[@class='product media']//img[contains(@src, 'magento-logo')]"); // stepKey: seeImageAssertProductImageStorefrontProductPage
		$I->comment("Exiting Action Group [assertProductImageStorefrontProductPage] AssertProductImageStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [findCreatedProductInGrid] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexFindCreatedProductInGrid
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadFindCreatedProductInGrid
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageFindCreatedProductInGrid
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetFindCreatedProductInGrid
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetFindCreatedProductInGridWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionFindCreatedProductInGrid
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonFindCreatedProductInGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonFindCreatedProductInGridWaitForPageLoad
		$I->comment("Exiting Action Group [findCreatedProductInGrid] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [goToEditProductPage] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowGoToEditProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadGoToEditProductPage
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageGoToEditProductPage
		$I->comment("Exiting Action Group [goToEditProductPage] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [addFirstImageToProduct] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddFirstImageToProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddFirstImageToProduct
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddFirstImageToProduct
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileAddFirstImageToProduct
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddFirstImageToProduct
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddFirstImageToProduct
		$I->comment("Exiting Action Group [addFirstImageToProduct] AddProductImageActionGroup");
		$I->comment("Entering Action Group [addSecondImageToProduct] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddSecondImageToProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddSecondImageToProduct
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddSecondImageToProduct
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileAddSecondImageToProduct
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddSecondImageToProduct
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddSecondImageToProduct
		$I->comment("Exiting Action Group [addSecondImageToProduct] AddProductImageActionGroup");
		$I->comment("Entering Action Group [addThirdImageToProduct] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddThirdImageToProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddThirdImageToProduct
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddThirdImageToProduct
		$I->attachFile("#fileupload", "magento-again.jpg"); // stepKey: uploadFileAddThirdImageToProduct
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddThirdImageToProduct
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]", 30); // stepKey: waitForThumbnailAddThirdImageToProduct
		$I->comment("Exiting Action Group [addThirdImageToProduct] AddProductImageActionGroup");
		$I->comment("Entering Action Group [openCreatedProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenCreatedProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenCreatedProductPage
		$I->comment("Exiting Action Group [openCreatedProductPage] StorefrontOpenProductPageActionGroup");
		$I->dontSeeElement("//*[@data-gallery-role='gallery']//*[@data-gallery-role='nav-wrap']//*[@data-gallery-role='arrow' and contains(@class, 'fotorama__thumb__arr--left')]"); // stepKey: dontSeePrevButton
		$I->waitForPageLoad(30); // stepKey: dontSeePrevButtonWaitForPageLoad
		$I->dontSeeElement("//*[@data-gallery-role='gallery']//*[@data-gallery-role='nav-wrap']//*[@data-gallery-role='arrow' and contains(@class, 'fotorama__thumb__arr--right')]"); // stepKey: dontSeeNextButton
		$I->waitForPageLoad(30); // stepKey: dontSeeNextButtonWaitForPageLoad
	}
}
