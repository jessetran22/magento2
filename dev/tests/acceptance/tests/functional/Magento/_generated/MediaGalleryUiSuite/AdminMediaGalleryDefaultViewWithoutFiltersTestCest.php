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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/5199870: User shouldn't see applied filters if media gallery switched to Default View")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/5199870")
 * @Description("No filters should be applied if Default View selected<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminMediaGalleryDefaultViewWithoutFiltersTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminMediaGalleryDefaultViewWithoutFiltersTestCest
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
	 * @Features({"MediaGalleryUi"})
	 * @Stories({"Media gallery default directory"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryDefaultViewWithoutFiltersTest(AcceptanceTester $I)
	{
		$I->comment("Open category page");
		$I->comment("Entering Action Group [openCategoryPage] AdminOpenCategoryGridPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery_catalog/category/index"); // stepKey: navigateToCategoryGridPageOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCategoryPage
		$I->comment("Exiting Action Group [openCategoryPage] AdminOpenCategoryGridPageActionGroup");
		$I->comment("Entering Action Group [editCategoryItem] AdminEditCategoryInGridPageActionGroup");
		$I->click("//tr[td//text()[contains(., '" . $I->retrieveEntityField('category', 'name', 'test') . "')]]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Action')]/preceding-sibling::th) +1 ]//*[text()='Edit']"); // stepKey: clickOnCategoryRowEditCategoryItem
		$I->waitForPageLoad(30); // stepKey: waitForCategoryDetailsPageLoadEditCategoryItem
		$I->comment("Exiting Action Group [editCategoryItem] AdminEditCategoryInGridPageActionGroup");
		$I->comment("Open media gallery folder");
		$I->comment("Entering Action Group [openMediaGallery] AdminOpenMediaGalleryFromCategoryImageUploaderActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Select from Gallery']", false); // stepKey: clickExpandContentOpenMediaGallery
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Select from Gallery']", 30); // stepKey: waitForSelectFromGalleryOpenMediaGallery
		$I->click("//*[@class='file-uploader-area']/label[text()='Select from Gallery']"); // stepKey: clickSelectFromGalleryOpenMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGallery
		$I->comment("Exiting Action Group [openMediaGallery] AdminOpenMediaGalleryFromCategoryImageUploaderActionGroup");
		$I->comment("Entering Action Group [selectDefaultView] AdminEnhancedMediaGallerySelectCustomBookmarksViewActionGroup");
		$I->click("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: openViewBookmarksSelectDefaultView
		$I->waitForPageLoad(30); // stepKey: openViewBookmarksSelectDefaultViewWaitForPageLoad
		$I->click("//a[@class='action-dropdown-menu-link'][contains(text(), 'Default View')]"); // stepKey: clickOnViewButtonSelectDefaultView
		$I->waitForPageLoad(5); // stepKey: clickOnViewButtonSelectDefaultViewWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitForGridLoadSelectDefaultView
		$I->comment("Exiting Action Group [selectDefaultView] AdminEnhancedMediaGallerySelectCustomBookmarksViewActionGroup");
		$I->comment("Asset folder is empty");
		$I->comment("Entering Action Group [assertEmptyFolder] AdminEnhancedMediaGalleryAssertNoActiveFiltersAppliedActionGroup");
		$I->dontSeeElement("//div[@class='media-gallery-container']//div[@class='admin__current-filters-list-wrap']"); // stepKey: assertThereIsNoActiveFiltersAssertEmptyFolder
		$I->comment("Exiting Action Group [assertEmptyFolder] AdminEnhancedMediaGalleryAssertNoActiveFiltersAppliedActionGroup");
	}
}
