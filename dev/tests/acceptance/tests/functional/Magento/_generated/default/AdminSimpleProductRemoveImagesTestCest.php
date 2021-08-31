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
 * @Title("MC-25383: Remove Product Images assigned as Base, Small and Thumbnail from Simple Product")
 * @Description("Admin should be able to remove Product Images assigned as Base, Small and Thumbnail from Simple Product<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminSimpleProductImagesTest/AdminSimpleProductRemoveImagesTest.xml<br>")
 * @TestCaseId("MC-25383")
 * @group catalog
 */
class AdminSimpleProductRemoveImagesTestCest
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
		$I->createEntity("category", "hook", "_defaultCategory", [], []); // stepKey: category
		$I->createEntity("product", "hook", "_defaultProduct", ["category"], []); // stepKey: product
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
		$I->deleteEntity("category", "hook"); // stepKey: deletePreReqCategory
		$I->deleteEntity("product", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [clearProductGridFilters] ClearProductsFilterActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexClearProductGridFilters
		$I->waitForPageLoad(30); // stepKey: waitForProductsPageToLoadClearProductGridFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetClearProductGridFilters
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetClearProductGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductGridFilters] ClearProductsFilterActionGroup");
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
	 * @Features({"Catalog"})
	 * @Stories({"Add/remove images and videos for all product types and category"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminSimpleProductRemoveImagesTest(AcceptanceTester $I)
	{
		$I->comment("Go to the product edit page");
		$I->comment("Entering Action Group [goToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageGoToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadGoToProductIndex
		$I->comment("Exiting Action Group [goToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetProductGrid] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductGridWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetProductGrid
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetProductGrid
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetProductGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetProductGrid
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetProductGrid
		$I->comment("Exiting Action Group [resetProductGrid] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [filterProductGridBySku] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGridBySku
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridBySkuWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridBySku
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('product', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridBySku
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridBySku
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridBySkuWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridBySku
		$I->comment("Exiting Action Group [filterProductGridBySku] FilterProductGridBySkuActionGroup");
		$I->comment("Entering Action Group [openProduct] AdminProductGridSectionClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickOnProductPageOpenProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenProduct
		$I->comment("Exiting Action Group [openProduct] AdminProductGridSectionClickFirstRowActionGroup");
		$I->comment("Set url key");
		$I->comment("BIC workaround");
		$I->comment("BIC workaround");
		$I->comment("Expand images section");
		$I->comment("Entering Action Group [expandImages] AdminOpenProductImagesSectionActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionExpandImages
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title"); // stepKey: scrollToProductImagesSectionExpandImages
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMediaContentExpandImages
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: waitForImageUploadButtonExpandImages
		$I->comment("Exiting Action Group [expandImages] AdminOpenProductImagesSectionActionGroup");
		$I->comment("Upload and set Base image");
		$I->attachFile("#fileupload", "adobe-base.jpg"); // stepKey: attach1
		$I->waitForPageLoad(30); // stepKey: waitForUpload1
		$I->click("#media_gallery_content > div:nth-child(1) img.product-image"); // stepKey: openImageDetails1
		$I->waitForPageLoad(30); // stepKey: waitForSlideout1
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Base']", "//div[contains(@class, 'field-image-role')]//ul/li[contains(@class, 'selected')]/label[normalize-space(.) = 'Base']", false); // stepKey: base1
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Small']", "//div[contains(@class, 'field-image-role')]//ul/li[contains(@class, 'selected')]/label[normalize-space(.) = 'Small']", true); // stepKey: small1
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Thumbnail']", "//div[contains(@class, 'field-image-role')]//ul/li[contains(@class, 'selected')]/label[normalize-space(.) = 'Thumbnail']", true); // stepKey: thumbnail1
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Swatch']", "//div[contains(@class, 'field-image-role')]//ul/li[contains(@class, 'selected')]/label[normalize-space(.) = 'Swatch']", true); // stepKey: swatch1
		$I->pressKey("textarea[data-role='image-description']", \Facebook\WebDriver\WebDriverKeys::ESCAPE); // stepKey: pressEsc1
		$I->waitForPageLoad(30); // stepKey: waitForHide1
		$I->comment("Upload and set Small image");
		$I->attachFile("#fileupload", "adobe-small.jpg"); // stepKey: attach2
		$I->waitForPageLoad(30); // stepKey: waitForUpload2
		$I->click("#media_gallery_content > div:nth-child(2) img.product-image"); // stepKey: openImageDetails2
		$I->waitForPageLoad(30); // stepKey: waitForSlideout2
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Base']", "//div[contains(@class, 'field-image-role')]//ul/li[contains(@class, 'selected')]/label[normalize-space(.) = 'Base']", true); // stepKey: base2
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Small']", "//div[contains(@class, 'field-image-role')]//ul/li[contains(@class, 'selected')]/label[normalize-space(.) = 'Small']", false); // stepKey: small2
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Thumbnail']", "//div[contains(@class, 'field-image-role')]//ul/li[contains(@class, 'selected')]/label[normalize-space(.) = 'Thumbnail']", true); // stepKey: thumbnail2
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Swatch']", "//div[contains(@class, 'field-image-role')]//ul/li[contains(@class, 'selected')]/label[normalize-space(.) = 'Swatch']", true); // stepKey: swatch2
		$I->pressKey("textarea[data-role='image-description']", \Facebook\WebDriver\WebDriverKeys::ESCAPE); // stepKey: pressEsc2
		$I->waitForPageLoad(30); // stepKey: waitForHide2
		$I->comment("Upload and set Thumbnail image");
		$I->attachFile("#fileupload", "adobe-thumb.jpg"); // stepKey: attach3
		$I->waitForPageLoad(30); // stepKey: waitForUpload3
		$I->click("#media_gallery_content > div:nth-child(3) img.product-image"); // stepKey: openImageDetails3
		$I->waitForPageLoad(30); // stepKey: waitForSlideout3
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Base']", "//div[contains(@class, 'field-image-role')]//ul/li[contains(@class, 'selected')]/label[normalize-space(.) = 'Base']", true); // stepKey: base3
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Small']", "//div[contains(@class, 'field-image-role')]//ul/li[contains(@class, 'selected')]/label[normalize-space(.) = 'Small']", true); // stepKey: small3
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Thumbnail']", "//div[contains(@class, 'field-image-role')]//ul/li[contains(@class, 'selected')]/label[normalize-space(.) = 'Thumbnail']", false); // stepKey: thumbnail3
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Swatch']", "//div[contains(@class, 'field-image-role')]//ul/li[contains(@class, 'selected')]/label[normalize-space(.) = 'Swatch']", true); // stepKey: swatch3
		$I->pressKey("textarea[data-role='image-description']", \Facebook\WebDriver\WebDriverKeys::ESCAPE); // stepKey: pressEsc3
		$I->waitForPageLoad(30); // stepKey: waitForHide3
		$I->comment("Save the product with all 3 images");
		$I->comment("Entering Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: saveProductSaveProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveProduct
		$I->comment("Exiting Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->comment("Go to the product page and see the Base image");
		$I->amOnPage("/" . $I->retrieveEntityField('product', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage
		$I->waitForPageLoad(30); // stepKey: wait4
		$I->seeElement("//*[@class='product media']//img[contains(@src, '/adobe-base')]"); // stepKey: seeBase
		$I->comment("Go to the category page and see the Small image");
		$I->amOnPage("/" . $I->retrieveEntityField('category', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToCategoryPage
		$I->waitForPageLoad(30); // stepKey: wait3
		$I->seeElement(".products-grid img[src*='/adobe-small']"); // stepKey: seeThumb
		$I->comment("Go to the admin grid and see the Thumbnail image");
		$I->comment("Entering Action Group [goToProductIndex2] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageGoToProductIndex2
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadGoToProductIndex2
		$I->comment("Exiting Action Group [goToProductIndex2] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetProductGrid2] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductGrid2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductGrid2WaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetProductGrid2
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetProductGrid2
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetProductGrid2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetProductGrid2
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetProductGrid2
		$I->comment("Exiting Action Group [resetProductGrid2] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [filterProductGridBySku2] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGridBySku2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridBySku2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridBySku2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('product', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridBySku2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridBySku2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridBySku2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridBySku2
		$I->comment("Exiting Action Group [filterProductGridBySku2] FilterProductGridBySkuActionGroup");
		$I->seeElement("img.admin__control-thumbnail[src*='/adobe-thumb']"); // stepKey: seeBaseInGrid
		$I->comment("Go to the product edit page again");
		$I->comment("Entering Action Group [goToProductIndex3] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageGoToProductIndex3
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadGoToProductIndex3
		$I->comment("Exiting Action Group [goToProductIndex3] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetProductGrid3] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductGrid3
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductGrid3WaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetProductGrid3
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetProductGrid3
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetProductGrid3WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetProductGrid3
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetProductGrid3
		$I->comment("Exiting Action Group [resetProductGrid3] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [filterProductGridBySku3] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGridBySku3
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridBySku3WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridBySku3
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('product', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridBySku3
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridBySku3
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridBySku3WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridBySku3
		$I->comment("Exiting Action Group [filterProductGridBySku3] FilterProductGridBySkuActionGroup");
		$I->comment("Entering Action Group [openProduct3] AdminProductGridSectionClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickOnProductPageOpenProduct3
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenProduct3
		$I->comment("Exiting Action Group [openProduct3] AdminProductGridSectionClickFirstRowActionGroup");
		$I->comment("Entering Action Group [expandImages2] AdminOpenProductImagesSectionActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionExpandImages2
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title"); // stepKey: scrollToProductImagesSectionExpandImages2
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMediaContentExpandImages2
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: waitForImageUploadButtonExpandImages2
		$I->comment("Exiting Action Group [expandImages2] AdminOpenProductImagesSectionActionGroup");
		$I->comment("Remove all images");
		$I->waitForElementVisible("#media_gallery_content > div:nth-child(1) button.action-remove", 30); // stepKey: waitForRemoveImageButtonVisible
		$I->click("#media_gallery_content > div:nth-child(1) button.action-remove"); // stepKey: removeImage1
		$I->click("#media_gallery_content > div:nth-child(2) button.action-remove"); // stepKey: removeImage2
		$I->click("#media_gallery_content > div:nth-child(3) button.action-remove"); // stepKey: removeImage3
		$I->comment("Entering Action Group [saveProduct2] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveProduct2
		$I->waitForPageLoad(30); // stepKey: saveProductSaveProduct2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveProduct2
		$I->comment("Exiting Action Group [saveProduct2] AdminProductFormSaveActionGroup");
		$I->comment("Check admin grid for placeholder");
		$I->comment("Entering Action Group [goToProductIndex4] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageGoToProductIndex4
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadGoToProductIndex4
		$I->comment("Exiting Action Group [goToProductIndex4] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetProductGrid4] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductGrid4
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductGrid4WaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetProductGrid4
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetProductGrid4
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetProductGrid4WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetProductGrid4
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetProductGrid4
		$I->comment("Exiting Action Group [resetProductGrid4] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [filterProductGridBySku4] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGridBySku4
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridBySku4WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridBySku4
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('product', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridBySku4
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridBySku4
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridBySku4WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridBySku4
		$I->comment("Exiting Action Group [filterProductGridBySku4] FilterProductGridBySkuActionGroup");
		$I->dontSeeElement("img.admin__control-thumbnail[src*='/adobe-thumb']"); // stepKey: dontSeeBaseInGrid
		$I->seeElement("img.admin__control-thumbnail[src*='/placeholder/thumbnail']"); // stepKey: seePlaceholderThumb
		$I->comment("Check category page for placeholder");
		$I->amOnPage("/" . $I->retrieveEntityField('category', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToCategoryPage2
		$I->waitForPageLoad(30); // stepKey: wait7
		$I->dontSeeElement(".products-grid img[src*='/adobe-small']"); // stepKey: dontSeeThumb
		$I->seeElement(".products-grid img[src*='placeholder/small_image']"); // stepKey: seePlaceholderSmall
		$I->comment("Check product page for placeholder");
		$I->amOnPage("/" . $I->retrieveEntityField('product', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage2
		$I->waitForPageLoad(30); // stepKey: wait8
		$I->dontSeeElement("//*[@class='product media']//img[contains(@src, '/adobe-base')]"); // stepKey: dontSeeBase
		$I->seeElement("//*[@class='product media']//img[contains(@src, 'placeholder/image')]"); // stepKey: seePlaceholderBase
	}
}
