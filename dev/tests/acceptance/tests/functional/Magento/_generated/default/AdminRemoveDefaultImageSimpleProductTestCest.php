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
 * @Title("MC-195: Admin should be able to remove default images from a Simple Product")
 * @Description("Admin should be able to remove default images from a Simple Product<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminRemoveDefaultImageSimpleProductTest.xml<br>")
 * @TestCaseId("MC-195")
 * @group Catalog
 */
class AdminRemoveDefaultImageSimpleProductTestCest
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
	public function AdminRemoveDefaultImageSimpleProductTest(AcceptanceTester $I)
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
		$I->comment("Remove image from product");
		$I->comment("Entering Action Group [removeProductImage] RemoveProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionRemoveProductImage
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshRemoveProductImage
		$I->click(".action-remove"); // stepKey: clickRemoveImageRemoveProductImage
		$I->comment("Exiting Action Group [removeProductImage] RemoveProductImageActionGroup");
		$I->comment("Entering Action Group [saveProductFormAfterRemove] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductFormAfterRemove
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductFormAfterRemove
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductFormAfterRemoveWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductFormAfterRemove
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductFormAfterRemoveWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductFormAfterRemove
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductFormAfterRemove
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductFormAfterRemove
		$I->comment("Exiting Action Group [saveProductFormAfterRemove] SaveProductFormActionGroup");
		$I->comment("Assert product image not in admin product form");
		$I->comment("Entering Action Group [assertProductImageNotInAdminProductPage] AssertProductImageNotInAdminProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProductImageNotInAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProductImageNotInAdminProductPage
		$I->dontSeeElement("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]"); // stepKey: seeImageAssertProductImageNotInAdminProductPage
		$I->comment("Exiting Action Group [assertProductImageNotInAdminProductPage] AssertProductImageNotInAdminProductPageActionGroup");
		$I->comment("Assert product in storefront product page");
		$I->comment("Entering Action Group [AssertProductInStorefrontProductPageAfterRemove] AssertProductInStorefrontProductPageActionGroup");
		$I->comment("Go to storefront product page, assert product name, sku and price");
		$I->amOnPage("simple-product-3-" . msq("SimpleProduct3") . ".html"); // stepKey: navigateToProductPageAssertProductInStorefrontProductPageAfterRemove
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssertProductInStorefrontProductPageAfterRemove
		$I->seeInTitle("Simple Product 3 " . msq("SimpleProduct3")); // stepKey: assertProductNameTitleAssertProductInStorefrontProductPageAfterRemove
		$I->see("Simple Product 3 " . msq("SimpleProduct3"), ".base"); // stepKey: assertProductNameAssertProductInStorefrontProductPageAfterRemove
		$I->see("123.00", "div.price-box.price-final_price"); // stepKey: assertProductPriceAssertProductInStorefrontProductPageAfterRemove
		$I->see("SimpleProduct3" . msq("SimpleProduct3"), ".product.attribute.sku>.value"); // stepKey: assertProductSkuAssertProductInStorefrontProductPageAfterRemove
		$I->comment("Exiting Action Group [AssertProductInStorefrontProductPageAfterRemove] AssertProductInStorefrontProductPageActionGroup");
		$I->comment("Assert product image not in storefront product page");
		$I->comment("Entering Action Group [assertProductImageNotInStorefrontProductPage] AssertProductImageNotInStorefrontProductPageActionGroup");
		$I->seeInCurrentUrl("/simple-product-3-" . msq("SimpleProduct3") . ".html"); // stepKey: checkUrlAssertProductImageNotInStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProductImageNotInStorefrontProductPage
		$I->dontSeeElement("//*[@class='product media']//img[contains(@src, 'magento-logo')]"); // stepKey: seeImageAssertProductImageNotInStorefrontProductPage
		$I->comment("Exiting Action Group [assertProductImageNotInStorefrontProductPage] AssertProductImageNotInStorefrontProductPageActionGroup");
	}
}
