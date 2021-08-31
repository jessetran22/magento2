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
 * @Title("MC-6048: Can delete a root category not assigned to any store")
 * @Description("Login as admin and delete a root category not assigned to any store<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminDeleteRootCategoryTest.xml<br>")
 * @TestCaseId("MC-6048")
 * @group Catalog
 * @group mtf_migrated
 */
class AdminDeleteRootCategoryTestCest
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
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->createEntity("rootCategory", "hook", "NewRootCategory", [], []); // stepKey: rootCategory
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Delete categories"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteRootCategoryTest(AcceptanceTester $I)
	{
		$I->comment("Verify Created root Category");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [expandCategoryTree] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeExpandCategoryTree
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadExpandCategoryTree
		$I->comment("Exiting Action Group [expandCategoryTree] AdminExpandCategoryTreeActionGroup");
		$I->comment("Entering Action Group [seeRootCategory] AssertAdminCategoryIsListedInCategoriesTreeActionGroup");
		$I->seeElement("//a/span[contains(text(), 'NewRootCategory" . msq("NewRootCategory") . "')]"); // stepKey: seeCategoryInTreeSeeRootCategory
		$I->waitForPageLoad(30); // stepKey: seeCategoryInTreeSeeRootCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [seeRootCategory] AssertAdminCategoryIsListedInCategoriesTreeActionGroup");
		$I->comment("Delete Root Category");
		$I->deleteEntity("rootCategory", "test"); // stepKey: deleteRootCategory
		$I->comment("Verify Root Category is not listed in backend");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage1] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage1
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage1
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage1] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [expandTheCategoryTree] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeExpandTheCategoryTree
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadExpandTheCategoryTree
		$I->comment("Exiting Action Group [expandTheCategoryTree] AdminExpandCategoryTreeActionGroup");
		$I->comment("Entering Action Group [doNotSeeRootCategory] AssertAdminCategoryIsNotListedInCategoriesTreeActionGroup");
		$I->dontSee("//a/span[contains(text(), 'NewRootCategory" . msq("NewRootCategory") . "')]"); // stepKey: doNotSeeCategoryInTreeDoNotSeeRootCategory
		$I->waitForPageLoad(30); // stepKey: doNotSeeCategoryInTreeDoNotSeeRootCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [doNotSeeRootCategory] AssertAdminCategoryIsNotListedInCategoriesTreeActionGroup");
	}
}
