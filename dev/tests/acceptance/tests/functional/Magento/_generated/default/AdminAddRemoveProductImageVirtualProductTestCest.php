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
 * @Title("MC-103: Admin should be able to add default images for a Virtual Product")
 * @Description("Admin should be able to add default images for a Virtual Product<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminAddDefaultImageVirtualProductTest.xml<br>")
 * @TestCaseId("MC-103")
 * @group Catalog
 */
class AdminAddRemoveProductImageVirtualProductTestCest
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
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAddRemoveProductImageVirtualProductTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [goToCreateProduct] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleGoToCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleGoToCreateProductWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-virtual']", 30); // stepKey: waitForAddProductDropdownGoToCreateProduct
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-virtual']"); // stepKey: clickAddProductTypeGoToCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadGoToCreateProduct
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/virtual/"); // stepKey: seeNewProductUrlGoToCreateProduct
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleGoToCreateProduct
		$I->comment("Exiting Action Group [goToCreateProduct] GoToCreateProductPageActionGroup");
		$I->comment("Entering Action Group [fillProductMain] FillMainProductFormNoWeightActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "virtualProduct" . msq("defaultVirtualProduct")); // stepKey: fillProductNameFillProductMain
		$I->fillField(".admin__field[data-index=sku] input", "virtualProduct" . msq("defaultVirtualProduct")); // stepKey: fillProductSkuFillProductMain
		$I->fillField(".admin__field[data-index=price] input", "12.34"); // stepKey: fillProductPriceFillProductMain
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillProductMain
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillProductMain
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillProductMainWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has no weight"); // stepKey: selectWeightFillProductMain
		$I->comment("Exiting Action Group [fillProductMain] FillMainProductFormNoWeightActionGroup");
		$I->comment("Add image to product");
		$I->comment("Entering Action Group [addImageForProduct] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddImageForProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddImageForProduct
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddImageForProduct
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileAddImageForProduct
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageForProduct
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddImageForProduct
		$I->comment("Exiting Action Group [addImageForProduct] AddProductImageActionGroup");
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
		$I->comment("Assert product image in admin product form");
		$I->comment("Entering Action Group [assertProductImageAdminProductPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProductImageAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProductImageAdminProductPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: seeImageAssertProductImageAdminProductPage
		$I->comment("Exiting Action Group [assertProductImageAdminProductPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->comment("Assert product in storefront product page");
		$I->comment("Entering Action Group [AssertProductInStorefrontProductPage] AssertProductInStorefrontProductPageActionGroup");
		$I->comment("Go to storefront product page, assert product name, sku and price");
		$I->amOnPage("virtualproduct" . msq("defaultVirtualProduct") . ".html"); // stepKey: navigateToProductPageAssertProductInStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssertProductInStorefrontProductPage
		$I->seeInTitle("virtualProduct" . msq("defaultVirtualProduct")); // stepKey: assertProductNameTitleAssertProductInStorefrontProductPage
		$I->see("virtualProduct" . msq("defaultVirtualProduct"), ".base"); // stepKey: assertProductNameAssertProductInStorefrontProductPage
		$I->see("12.34", "div.price-box.price-final_price"); // stepKey: assertProductPriceAssertProductInStorefrontProductPage
		$I->see("virtualProduct" . msq("defaultVirtualProduct"), ".product.attribute.sku>.value"); // stepKey: assertProductSkuAssertProductInStorefrontProductPage
		$I->comment("Exiting Action Group [AssertProductInStorefrontProductPage] AssertProductInStorefrontProductPageActionGroup");
		$I->comment("Assert product image in storefront product page");
		$I->comment("Entering Action Group [assertProductImageStorefrontProductPage] AssertProductImageStorefrontProductPageActionGroup");
		$I->seeInCurrentUrl("/virtualproduct" . msq("defaultVirtualProduct") . ".html"); // stepKey: checkUrlAssertProductImageStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProductImageStorefrontProductPage
		$I->seeElement("//*[@class='product media']//img[contains(@src, 'magento-logo')]"); // stepKey: seeImageAssertProductImageStorefrontProductPage
		$I->comment("Exiting Action Group [assertProductImageStorefrontProductPage] AssertProductImageStorefrontProductPageActionGroup");
	}
}
