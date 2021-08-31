<?php
namespace Magento\AcceptanceTest\_MediaGalleryUiSuite\Backend;

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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/943908/scenarios/4523889: User sees category entities where asset is used in")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/943908/scenarios/4523889")
 * @Description("User sees category entities where asset is used in<h3>Test files</h3>app/code/Magento/MediaGalleryCatalogUi/Test/Mftf/Test/AdminMediaGalleryCatalogUiVerifyCategoryGridPageTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminMediaGalleryCatalogUiVerifyCategoryGridPageTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("category", "hook", "SimpleSubCategory", [], []); // stepKey: category
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
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
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
	 * @Features({"MediaGalleryCatalogUi"})
	 * @Stories({"Story 58: User sees entities where asset is used in"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryCatalogUiVerifyCategoryGridPageTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openCategoryPage] AdminOpenCategoryGridPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery_catalog/category/index"); // stepKey: navigateToCategoryGridPageOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCategoryPage
		$I->comment("Exiting Action Group [openCategoryPage] AdminOpenCategoryGridPageActionGroup");
		$I->comment("Entering Action Group [searchByCategoryName] AdminSearchCategoryGridPageByCategoryNameActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchByCategoryName
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchByCategoryNameWaitForPageLoad
		$I->fillField(".admin__data-grid-header input[placeholder='Search by category name']", $I->retrieveEntityField('category', 'name', 'test')); // stepKey: fillKeywordSearchFieldSearchByCategoryName
		$I->click(".data-grid-search-control-wrap > button.action-submit"); // stepKey: clickKeywordSearchSearchByCategoryName
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchByCategoryNameWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitingForLoadingSearchByCategoryName
		$I->comment("Exiting Action Group [searchByCategoryName] AdminSearchCategoryGridPageByCategoryNameActionGroup");
		$I->comment("Entering Action Group [assertOneRecordInGrid] AssertAdminCategoryGridPageNumberOfRecordsActionGroup");
		$grabNumberOfRecordsFoundAssertOneRecordInGrid = $I->grabTextFrom(".admin__data-grid-header .admin__control-support-text"); // stepKey: grabNumberOfRecordsFoundAssertOneRecordInGrid
		$I->assertEquals("1 records found", $grabNumberOfRecordsFoundAssertOneRecordInGrid); // stepKey: assertStringIsEqualAssertOneRecordInGrid
		$I->comment("Exiting Action Group [assertOneRecordInGrid] AssertAdminCategoryGridPageNumberOfRecordsActionGroup");
		$I->comment("Entering Action Group [assertCategoryGridPageImageColumn] AssertAdminCategoryGridPageImageColumnActionGroup");
		$getImageSrcAssertCategoryGridPageImageColumn = $I->grabAttributeFrom("//tr//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Image')]/preceding-sibling::th) +1]//img", "src"); // stepKey: getImageSrcAssertCategoryGridPageImageColumn
		$I->assertStringContainsString("magento", $getImageSrcAssertCategoryGridPageImageColumn); // stepKey: assertImageSrcAssertCategoryGridPageImageColumn
		$I->comment("Exiting Action Group [assertCategoryGridPageImageColumn] AssertAdminCategoryGridPageImageColumnActionGroup");
		$I->comment("Entering Action Group [assertCategoryGridPageRendered] AssertAdminCategoryGridPageDetailsActionGroup");
		$grabNameColumnValueAssertCategoryGridPageRendered = $I->grabTextFrom("//tr//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Name')]/preceding-sibling::th) +1 ]//div"); // stepKey: grabNameColumnValueAssertCategoryGridPageRendered
		$I->assertEquals($I->retrieveEntityField('category', 'name', 'test'), $grabNameColumnValueAssertCategoryGridPageRendered); // stepKey: assertNameColumnAssertCategoryGridPageRendered
		$grabPathColumnValueAssertCategoryGridPageRendered = $I->grabTextFrom("//tr//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Path')]/preceding-sibling::th) +1 ]//div"); // stepKey: grabPathColumnValueAssertCategoryGridPageRendered
		$I->assertStringContainsString($I->retrieveEntityField('category', 'name', 'test'), $grabPathColumnValueAssertCategoryGridPageRendered); // stepKey: assertPathColumnAssertCategoryGridPageRendered
		$I->comment("Exiting Action Group [assertCategoryGridPageRendered] AssertAdminCategoryGridPageDetailsActionGroup");
		$I->comment("Entering Action Group [assertCategoryGridPageProductsInMenuEnabledColumns] AssertAdminCategoryGridPageProductsInMenuEnabledColumnsActionGroup");
		$grabProductsColumnValueAssertCategoryGridPageProductsInMenuEnabledColumns = $I->grabTextFrom("//tr//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Products')]/preceding-sibling::th) +1 ]//div"); // stepKey: grabProductsColumnValueAssertCategoryGridPageProductsInMenuEnabledColumns
		$I->assertEquals("0", $grabProductsColumnValueAssertCategoryGridPageProductsInMenuEnabledColumns); // stepKey: assertProductsColumnAssertCategoryGridPageProductsInMenuEnabledColumns
		$grabInMenuColumnValueAssertCategoryGridPageProductsInMenuEnabledColumns = $I->grabTextFrom("//tr//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'In Menu')]/preceding-sibling::th) +1 ]//div"); // stepKey: grabInMenuColumnValueAssertCategoryGridPageProductsInMenuEnabledColumns
		$I->assertEquals("Yes", $grabInMenuColumnValueAssertCategoryGridPageProductsInMenuEnabledColumns); // stepKey: assertInMenuColumnAssertCategoryGridPageProductsInMenuEnabledColumns
		$grabEnabledColumnValueAssertCategoryGridPageProductsInMenuEnabledColumns = $I->grabTextFrom("//tr//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Enabled')]/preceding-sibling::th) +1 ]//div"); // stepKey: grabEnabledColumnValueAssertCategoryGridPageProductsInMenuEnabledColumns
		$I->assertEquals("Yes", $grabEnabledColumnValueAssertCategoryGridPageProductsInMenuEnabledColumns); // stepKey: assertEnabledColumnAssertCategoryGridPageProductsInMenuEnabledColumns
		$I->comment("Exiting Action Group [assertCategoryGridPageProductsInMenuEnabledColumns] AssertAdminCategoryGridPageProductsInMenuEnabledColumnsActionGroup");
		$I->comment("Entering Action Group [resetAdminDataGridToDefaultView] ResetAdminDataGridToDefaultViewActionGroup");
		$I->waitForElementVisible("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']", 30); // stepKey: waitForViewBookmarksResetAdminDataGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: waitForViewBookmarksResetAdminDataGridToDefaultViewWaitForPageLoad
		$I->click("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: openViewBookmarksResetAdminDataGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: openViewBookmarksResetAdminDataGridToDefaultViewWaitForPageLoad
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: selectDefaultGridViewResetAdminDataGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: selectDefaultGridViewResetAdminDataGridToDefaultViewWaitForPageLoad
		$I->see("Default View", "div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: seeDefaultViewSelectedResetAdminDataGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: seeDefaultViewSelectedResetAdminDataGridToDefaultViewWaitForPageLoad
		$I->comment("Exiting Action Group [resetAdminDataGridToDefaultView] ResetAdminDataGridToDefaultViewActionGroup");
	}
}
