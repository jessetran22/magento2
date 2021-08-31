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
 * @Title("MC-189: Admin should be able to add images of different types and sizes to Simple Product")
 * @Description("Admin should be able to add images of different types and sizes to Simple Product<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminSimpleProductImagesTest/AdminSimpleProductImagesTest.xml<br>")
 * @TestCaseId("MC-189")
 * @group Catalog
 */
class AdminSimpleProductImagesTestCest
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
		$I->createEntity("firstProduct", "hook", "_defaultProduct", ["category"], []); // stepKey: firstProduct
		$I->createEntity("secondProduct", "hook", "_defaultProduct", ["category"], []); // stepKey: secondProduct
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
		$I->deleteEntity("firstProduct", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("secondProduct", "hook"); // stepKey: deleteSecondProduct
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
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminSimpleProductImagesTest(AcceptanceTester $I)
	{
		$I->comment("Go to the first product edit page");
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
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('firstProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridBySku
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridBySku
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridBySkuWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridBySku
		$I->comment("Exiting Action Group [filterProductGridBySku] FilterProductGridBySkuActionGroup");
		$I->comment("Entering Action Group [openProducForEditByClickingRow1Column2InProductGrid] OpenProductForEditByClickingRowXColumnYInProductGridActionGroup");
		$I->click("table.data-grid tr.data-row:nth-child(1) td:nth-child(2)"); // stepKey: openProductForEditOpenProducForEditByClickingRow1Column2InProductGrid
		$I->waitForPageLoad(30); // stepKey: openProductForEditOpenProducForEditByClickingRow1Column2InProductGridWaitForPageLoad
		$I->comment("Exiting Action Group [openProducForEditByClickingRow1Column2InProductGrid] OpenProductForEditByClickingRowXColumnYInProductGridActionGroup");
		$I->comment("Set url key");
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSection
		$I->waitForPageLoad(30); // stepKey: openSeoSectionWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", $I->retrieveEntityField('firstProduct', 'name', 'test')); // stepKey: fillUrlKey
		$I->click("div[data-index=gallery] .admin__collapsible-title"); // stepKey: expandImages
		$I->comment("*.bmp is not allowed");
		$I->attachFile("#fileupload", "bmp.bmp"); // stepKey: attachBmp
		$I->waitForPageLoad(30); // stepKey: waitForUploadBmp
		$I->see("bmp.bmp was not uploaded. Disallowed file type.", ".message.message-error.error"); // stepKey: seeErrorBmp
		$I->click("button.action-primary.action-accept"); // stepKey: closeModalBmp
		$I->comment("*.ico is not allowed");
		$I->attachFile("#fileupload", "ico.ico"); // stepKey: attachIco
		$I->waitForPageLoad(30); // stepKey: waitForUploadIco
		$I->see("ico.ico was not uploaded. Disallowed file type.", ".message.message-error.error"); // stepKey: seeErrorIco
		$I->click("button.action-primary.action-accept"); // stepKey: closeModalIco
		$I->comment("*.svg is not allowed");
		$I->attachFile("#fileupload", "svg.svg"); // stepKey: attachSvg
		$I->waitForPageLoad(30); // stepKey: waitForUploadSvg
		$I->see("svg.svg was not uploaded. Disallowed file type.", ".message.message-error.error"); // stepKey: seeErrorSvg
		$I->click("button.action-primary.action-accept"); // stepKey: closeModalSvg
		$I->comment("0kb size is not allowed");
		$I->attachFile("#fileupload", "empty.jpg"); // stepKey: attachEmpty
		$I->waitForPageLoad(30); // stepKey: waitForUploadEmpty
		$I->see("empty.jpg was not uploaded.", ".message.message-error.error"); // stepKey: seeErrorEmpty
		$I->click("button.action-primary.action-accept"); // stepKey: closeModalEmpty
		$I->comment("1~ kb is allowed");
		$I->attachFile("#fileupload", "small.jpg"); // stepKey: attachSmall
		$I->waitForPageLoad(30); // stepKey: waitForUploadSmall
		$I->dontSeeElement(".message.message-error.error"); // stepKey: dontSeeErrorSmall
		$I->comment("1~ mb is allowed");
		$I->attachFile("#fileupload", "medium.jpg"); // stepKey: attachMedium
		$I->waitForPageLoad(30); // stepKey: waitForUploadMedium
		$I->dontSeeElement(".message.message-error.error"); // stepKey: dontSeeErrorMedium
		$I->comment("10~ mb is allowed");
		$I->attachFile("#fileupload", "large.jpg"); // stepKey: attachLarge
		$I->waitForPageLoad(30); // stepKey: waitForUploadLarge
		$I->dontSeeElement(".message.message-error.error"); // stepKey: dontSeeErrorLarge
		$I->comment("*.gif is allowed");
		$I->attachFile("#fileupload", "gif.gif"); // stepKey: attachGif
		$I->waitForPageLoad(30); // stepKey: waitForUploadGif
		$I->dontSeeElement(".message.message-error.error"); // stepKey: dontSeeErrorGif
		$I->comment("*.jpg is allowed");
		$I->attachFile("#fileupload", "jpg.jpg"); // stepKey: attachJpg
		$I->waitForPageLoad(30); // stepKey: waitForUploadJpg
		$I->dontSeeElement(".message.message-error.error"); // stepKey: dontSeeErrorJpg
		$I->comment("*.png is allowed");
		$I->attachFile("#fileupload", "png.png"); // stepKey: attachPng
		$I->waitForPageLoad(30); // stepKey: waitForUploadPng
		$I->dontSeeElement(".message.message-error.error"); // stepKey: dontSeeErrorPng
		$I->comment("Save the first product and go to the storefront");
		$I->comment("Entering Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: saveProductSaveProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveProduct
		$I->comment("Exiting Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->amOnPage($I->retrieveEntityField('firstProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefront
		$I->comment("See all of the images that we uploaded");
		$I->seeElementInDOM("//*[@class='product media']//img[contains(@src, 'small')]"); // stepKey: seeSmall
		$I->seeElementInDOM("//*[@class='product media']//img[contains(@src, 'medium')]"); // stepKey: seeMedium
		$I->seeElementInDOM("//*[@class='product media']//img[contains(@src, 'large')]"); // stepKey: seeLarge
		$I->seeElementInDOM("//*[@class='product media']//img[contains(@src, 'gif')]"); // stepKey: seeGif
		$I->seeElementInDOM("//*[@class='product media']//img[contains(@src, 'jpg')]"); // stepKey: seeJpg
		$I->seeElementInDOM("//*[@class='product media']//img[contains(@src, 'png')]"); // stepKey: seePng
		$I->comment("Go to the category page and see a placeholder image for the second product");
		$I->amOnPage($I->retrieveEntityField('category', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToCategoryPage
		$I->seeElement(".products-grid img[src*='placeholder/small_image.jpg']"); // stepKey: seePlaceholder
		$I->comment("Go to the second product edit page");
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
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('secondProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridBySku2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridBySku2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridBySku2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridBySku2
		$I->comment("Exiting Action Group [filterProductGridBySku2] FilterProductGridBySkuActionGroup");
		$I->comment("Entering Action Group [openProducForEditByClickingRow1Column2InProductGrid2] OpenProductForEditByClickingRowXColumnYInProductGridActionGroup");
		$I->click("table.data-grid tr.data-row:nth-child(1) td:nth-child(2)"); // stepKey: openProductForEditOpenProducForEditByClickingRow1Column2InProductGrid2
		$I->waitForPageLoad(30); // stepKey: openProductForEditOpenProducForEditByClickingRow1Column2InProductGrid2WaitForPageLoad
		$I->comment("Exiting Action Group [openProducForEditByClickingRow1Column2InProductGrid2] OpenProductForEditByClickingRowXColumnYInProductGridActionGroup");
		$I->comment("Upload an image");
		$I->click("div[data-index=gallery] .admin__collapsible-title"); // stepKey: expandImages2
		$I->attachFile("#fileupload", "large.jpg"); // stepKey: attachLarge2
		$I->waitForPageLoad(30); // stepKey: waitForUploadLarge2
		$I->dontSeeElement(".message.message-error.error"); // stepKey: dontSeeErrorLarge2
		$I->comment("Set url key");
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSection2
		$I->waitForPageLoad(30); // stepKey: openSeoSection2WaitForPageLoad
		$I->fillField("input[name='product[url_key]']", $I->retrieveEntityField('secondProduct', 'name', 'test')); // stepKey: fillUrlKey2
		$I->comment("Save the second product");
		$I->click("#save-button"); // stepKey: saveProduct2
		$I->waitForPageLoad(30); // stepKey: saveProduct2WaitForPageLoad
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Go to the admin grid and see the uploaded image");
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
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('secondProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridBySku3
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridBySku3
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridBySku3WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridBySku3
		$I->comment("Exiting Action Group [filterProductGridBySku3] FilterProductGridBySkuActionGroup");
		$I->seeElement("img.admin__control-thumbnail[src*='/large']"); // stepKey: seeImgInGrid
		$I->comment("Go to the category page and see the uploaded image");
		$I->amOnPage($I->retrieveEntityField('category', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToCategoryPage2
		$I->seeElement(".products-grid img[src*='/large']"); // stepKey: seeUploadedImg
		$I->comment("Go to the product page and see the uploaded image");
		$I->amOnPage($I->retrieveEntityField('secondProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStorefront2
		$I->waitForPageLoad(30); // stepKey: waitForStorefront2
		$I->seeElementInDOM("//*[@class='product media']//img[contains(@src, 'large')]"); // stepKey: seeLarge2
	}
}
