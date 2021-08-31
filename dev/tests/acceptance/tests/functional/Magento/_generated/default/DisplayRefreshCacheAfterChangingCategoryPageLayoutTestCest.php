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
 * @Title("MC-17031: 'Refresh cache' admin notification is displayed when changing category page layout")
 * @Description("'Refresh cache' message is not displayed when changing category page layout<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/DisplayRefreshCacheAfterChangingCategoryPageLayoutTest.xml<br>")
 * @TestCaseId("MC-17031")
 * @group catalog
 */
class DisplayRefreshCacheAfterChangingCategoryPageLayoutTestCest
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
		$I->comment("Create category, flush cache and log in");
		$I->comment("Create category, flush cache and log in");
		$I->createEntity("simpleCategory", "hook", "SimpleSubCategory", [], []); // stepKey: simpleCategory
		$I->comment("Entering Action Group [logInAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogInAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogInAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogInAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogInAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLogInAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogInAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogInAsAdmin
		$I->comment("Exiting Action Group [logInAsAdmin] AdminLoginActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete category and log out");
		$I->comment("Delete category and log out");
		$I->deleteEntity("simpleCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [logOutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogOutFromAdmin
		$I->comment("Exiting Action Group [logOutFromAdmin] AdminLogoutActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Stories({"Category Layout Change"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function DisplayRefreshCacheAfterChangingCategoryPageLayoutTest(AcceptanceTester $I)
	{
		$I->comment("Navigate to category details page");
		$I->comment("Navigate to category details page");
		$I->comment("Entering Action Group [goToAdminCategoryPage] GoToAdminCategoryPageByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/edit/id/" . $I->retrieveEntityField('simpleCategory', 'id', 'test') . "/"); // stepKey: amOnAdminCategoryPageGoToAdminCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToAdminCategoryPage
		$I->see($I->retrieveEntityField('simpleCategory', 'id', 'test'), ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleGoToAdminCategoryPage
		$I->comment("Exiting Action Group [goToAdminCategoryPage] GoToAdminCategoryPageByIdActionGroup");
		$I->comment("Open design tab and set layout");
		$I->comment("Open design tab and set layout");
		$I->click("//strong[@class='admin__collapsible-title']//span[text()='Design']"); // stepKey: clickOnDesignTab
		$I->waitForElementVisible("select[name='page_layout']", 30); // stepKey: waitForLayoutDropDown
		$I->selectOption("select[name='page_layout']", "2 columns with right bar"); // stepKey: selectAnOption
		$I->click("#save"); // stepKey: clickSaveConfig
		$I->waitForPageLoad(30); // stepKey: clickSaveConfigWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitSaveToApply
		$I->comment("See if warning message displays");
		$I->comment("Entering Action Group [seeWarningMessage] AdminSystemMessagesWarningActionGroup");
		$I->waitForElementVisible("#system_messages .message-system-action-dropdown", 30); // stepKey: waitMessagesDropdownAppearsSeeWarningMessage
		$I->conditionalClick("#system_messages .message-system-action-dropdown", "#system_messages div.message-system-collapsible", false); // stepKey: openMessagesBlockIfCollapsedSeeWarningMessage
		$I->see("Please go to Cache Management and refresh cache types", "#system_messages div.message-warning"); // stepKey: seeWarningMessageSeeWarningMessage
		$I->comment("Exiting Action Group [seeWarningMessage] AdminSystemMessagesWarningActionGroup");
	}
}
