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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/5034526: User Edits Category from Category grid")
 * @Description("Edit Category from Media Gallery Category Grid<h3>Test files</h3>app/code/Magento/MediaGalleryCatalogUi/Test/Mftf/Test/AdminMediaGalleryCatalogUiEditCategoryFromGridPageTest.xml<br>")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/5034526")
 * @group media_gallery_ui
 */
class AdminMediaGalleryCatalogUiEditCategoryFromGridPageTestCest
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
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	public function AdminMediaGalleryCatalogUiEditCategoryFromGridPageTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openCategoryPage] AdminOpenCategoryGridPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery_catalog/category/index"); // stepKey: navigateToCategoryGridPageOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCategoryPage
		$I->comment("Exiting Action Group [openCategoryPage] AdminOpenCategoryGridPageActionGroup");
		$I->comment("Entering Action Group [resetGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersResetGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersResetGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [resetGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [editCategoryItem] AdminEditCategoryInGridPageActionGroup");
		$I->click("//tr[td//text()[contains(., '" . $I->retrieveEntityField('category', 'name', 'test') . "')]]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Action')]/preceding-sibling::th) +1 ]//*[text()='Edit']"); // stepKey: clickOnCategoryRowEditCategoryItem
		$I->waitForPageLoad(30); // stepKey: waitForCategoryDetailsPageLoadEditCategoryItem
		$I->comment("Exiting Action Group [editCategoryItem] AdminEditCategoryInGridPageActionGroup");
		$I->comment("Entering Action Group [assertCategoryByName] AdminAssertCategoryPageTitleActionGroup");
		$I->see("SimpleSubCategory" . msq("SimpleSubCategory"), "h1.page-title"); // stepKey: seeCategoryTitleAssertCategoryByName
		$I->comment("Exiting Action Group [assertCategoryByName] AdminAssertCategoryPageTitleActionGroup");
	}
}
