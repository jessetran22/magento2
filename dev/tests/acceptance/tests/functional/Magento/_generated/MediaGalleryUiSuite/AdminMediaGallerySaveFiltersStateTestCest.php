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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1337102/scenarios/4763040: User is able to use bookmarks controls for filter views in Standalone Media Gallery")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1337102/scenarios/4763040")
 * @Description("User is able to use bookmarks controls for filter views in Standalone Media Gallery<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminMediaGallerySaveFiltersStateTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminMediaGallerySaveFiltersStateTestCest
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
        $this->helperContainer->create("Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper");
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

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"MediaGalleryUi"})
	 * @Stories({"User is able to use bookmarks controls in Standalone Media Gallery"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGallerySaveFiltersStateTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openStandaloneMediaGalleryPage] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenStandaloneMediaGalleryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenStandaloneMediaGalleryPage
		$I->comment("Exiting Action Group [openStandaloneMediaGalleryPage] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->comment("Entering Action Group [expandFilters] AdminEnhancedMediaGalleryExpandFilterActionGroup");
		$I->click("//div[@class='media-gallery-container']//button[@data-action='grid-filter-expand']"); // stepKey: expandFilterExpandFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearExpandFilters
		$I->comment("Exiting Action Group [expandFilters] AdminEnhancedMediaGalleryExpandFilterActionGroup");
		$I->comment("Entering Action Group [applyLocalFilter] AdminEnhancedMediaGallerySelectSourceFilterActionGroup");
		$I->click("//div[@class='media-gallery-container']//select[@name='source']//option[@value='Local']"); // stepKey: openContextMenuApplyLocalFilter
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearApplyLocalFilter
		$I->comment("Exiting Action Group [applyLocalFilter] AdminEnhancedMediaGallerySelectSourceFilterActionGroup");
		$I->comment("Entering Action Group [applyFilters] AdminEnhancedMediaGalleryApplyFiltersActionGroup");
		$I->click("//div[@class='media-gallery-container']//button[@data-action='grid-filter-apply']"); // stepKey: applyFiltersApplyFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearApplyFilters
		$I->comment("Exiting Action Group [applyFilters] AdminEnhancedMediaGalleryApplyFiltersActionGroup");
		$I->comment("Entering Action Group [saveCustomView] AdminEnhancedMediaGallerySaveCustomViewActionGroup");
		$I->click("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: openViewBookmarksSaveCustomView
		$I->waitForPageLoad(30); // stepKey: openViewBookmarksSaveCustomViewWaitForPageLoad
		$I->click(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] .action-dropdown-menu-item-last a"); // stepKey: saveViewSaveCustomView
		$I->waitForPageLoad(5); // stepKey: saveViewSaveCustomViewWaitForPageLoad
		$I->fillField(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] ._edit input", "Test View"); // stepKey: inputViewNameSaveCustomView
		$I->pressKey(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] ._edit input", \Facebook\WebDriver\WebDriverKeys::ENTER); // stepKey: pressEnterKeySaveCustomView
		$I->comment("Exiting Action Group [saveCustomView] AdminEnhancedMediaGallerySaveCustomViewActionGroup");
		$I->comment("Entering Action Group [assertFilterApplied] AdminEnhancedMediaGalleryAssertActiveFiltersActionGroup");
		$I->click("//div[@class='media-gallery-container']//button[@data-action='grid-filter-expand']"); // stepKey: expandFiltersToCheckAppliedFilterAssertFilterApplied
		$I->see("Uploaded Locally", "//div[@class='media-gallery-container']//div[@class='admin__current-filters-list-wrap']//span[contains( ., 'Uploaded Locally')]"); // stepKey: verifyAppliedFilterAssertFilterApplied
		$I->comment("Exiting Action Group [assertFilterApplied] AdminEnhancedMediaGalleryAssertActiveFiltersActionGroup");
		$I->comment("Entering Action Group [selectDefaultView] AdminEnhancedMediaGallerySelectCustomBookmarksViewActionGroup");
		$I->click("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: openViewBookmarksSelectDefaultView
		$I->waitForPageLoad(30); // stepKey: openViewBookmarksSelectDefaultViewWaitForPageLoad
		$I->click("//a[@class='action-dropdown-menu-link'][contains(text(), 'Default View')]"); // stepKey: clickOnViewButtonSelectDefaultView
		$I->waitForPageLoad(5); // stepKey: clickOnViewButtonSelectDefaultViewWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitForGridLoadSelectDefaultView
		$I->comment("Exiting Action Group [selectDefaultView] AdminEnhancedMediaGallerySelectCustomBookmarksViewActionGroup");
		$I->comment("Entering Action Group [assertNoActiveFilters] AdminEnhancedMediaGalleryAssertNoActiveFiltersAppliedActionGroup");
		$I->dontSeeElement("//div[@class='media-gallery-container']//div[@class='admin__current-filters-list-wrap']"); // stepKey: assertThereIsNoActiveFiltersAssertNoActiveFilters
		$I->comment("Exiting Action Group [assertNoActiveFilters] AdminEnhancedMediaGalleryAssertNoActiveFiltersAppliedActionGroup");
		$I->comment("Entering Action Group [deleteView] AdminEnhancedMediaGalleryDeleteGridViewActionGroup");
		$I->click("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: openViewBookmarksDeleteView
		$I->waitForPageLoad(30); // stepKey: openViewBookmarksDeleteViewWaitForPageLoad
		$I->click("//a[@class='action-dropdown-menu-link'][contains(text(), 'Test View')]/following-sibling::div/button[@class='action-edit']"); // stepKey: clickEditButtonDeleteView
		$I->seeElement("//div[@data-bind='afterRender: \$data.setToolbarNode']//input/following-sibling::div/button[@class='action-delete']"); // stepKey: seeDeleteButtonDeleteView
		$I->click("//div[@data-bind='afterRender: \$data.setToolbarNode']//input/following-sibling::div/button[@class='action-delete']"); // stepKey: clickDeleteButtonDeleteView
		$I->waitForPageLoad(10); // stepKey: waitForDeletionDeleteView
		$I->comment("Exiting Action Group [deleteView] AdminEnhancedMediaGalleryDeleteGridViewActionGroup");
	}
}
