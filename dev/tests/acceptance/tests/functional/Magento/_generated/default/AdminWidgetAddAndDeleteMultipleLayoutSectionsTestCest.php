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
 * @Title("[NO TESTCASEID]: Add and Delete multiple layouts")
 * @Description("Admin should be able to Add and Delete multiple layouts<h3>Test files</h3>app/code/Magento/Widget/Test/Mftf/Test/AdminWidgetAddAndDeleteMultipleLayoutSectionsTest.xml<br>")
 * @group Widget
 */
class AdminWidgetAddAndDeleteMultipleLayoutSectionsTestCest
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
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
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
	 * @Features({"Widget"})
	 * @Stories({"Add and Delete multiple layouts when creating a Widget"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminWidgetAddAndDeleteMultipleLayoutSectionsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToContentWidgetsPageFirst] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToContentWidgetsPageFirst
		$I->click("li[data-ui-id='menu-magento-backend-content']"); // stepKey: clickOnMenuItemNavigateToContentWidgetsPageFirst
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToContentWidgetsPageFirstWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-widget-cms-widget-instance']"); // stepKey: clickOnSubmenuItemNavigateToContentWidgetsPageFirst
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToContentWidgetsPageFirstWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToContentWidgetsPageFirst] AdminNavigateMenuActionGroup");
		$I->comment("Entering Action Group [seePageTitleFirst] AdminAssertPageTitleActionGroup");
		$I->see("Widgets", ".page-title-wrapper h1"); // stepKey: assertPageTitleSeePageTitleFirst
		$I->comment("Exiting Action Group [seePageTitleFirst] AdminAssertPageTitleActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappear1
		$I->comment("Entering Action Group [addWidgetForTest] AdminCreateWidgetWthoutLayoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/widget_instance/new/"); // stepKey: amOnAdminNewWidgetPageAddWidgetForTest
		$I->selectOption("#code", "Catalog Products List"); // stepKey: setWidgetTypeAddWidgetForTest
		$I->selectOption("#theme_id", "Magento Luma"); // stepKey: setWidgetDesignThemeAddWidgetForTest
		$I->click("#continue_button"); // stepKey: clickContinueAddWidgetForTest
		$I->waitForPageLoad(30); // stepKey: clickContinueAddWidgetForTestWaitForPageLoad
		$I->fillField("#title", "TestWidget" . msq("ProductsListWidget")); // stepKey: fillTitleAddWidgetForTest
		$I->selectOption("#store_ids", "All Store Views"); // stepKey: setWidgetStoreIdsAddWidgetForTest
		$I->click(".action-default.scalable.action-add"); // stepKey: clickAddLayoutUpdateAddWidgetForTest
		$I->comment("Exiting Action Group [addWidgetForTest] AdminCreateWidgetWthoutLayoutActionGroup");
		$I->comment("Entering Action Group [AddSecondLayout] AdminWidgetAddLayoutUpdateActionGroup");
		$I->waitForAjaxLoad(30); // stepKey: waitForLoadAddSecondLayout
		$I->click(".action-default.scalable.action-add"); // stepKey: clickAddLayoutUpdateAddSecondLayout
		$I->comment("Exiting Action Group [AddSecondLayout] AdminWidgetAddLayoutUpdateActionGroup");
		$I->click(".page_group_container:last-child .action-default.scalable.action-delete"); // stepKey: clickRemoveLastLayoutUpdate
		$I->seeNumberOfElements(".page_group_container", "1"); // stepKey: seeOneLayoutUpdate
		$I->comment("Entering Action Group [AddSecondLayoutAgain] AdminWidgetAddLayoutUpdateActionGroup");
		$I->waitForAjaxLoad(30); // stepKey: waitForLoadAddSecondLayoutAgain
		$I->click(".action-default.scalable.action-add"); // stepKey: clickAddLayoutUpdateAddSecondLayoutAgain
		$I->comment("Exiting Action Group [AddSecondLayoutAgain] AdminWidgetAddLayoutUpdateActionGroup");
		$I->comment("Entering Action Group [AddThirdLayout] AdminWidgetAddLayoutUpdateActionGroup");
		$I->waitForAjaxLoad(30); // stepKey: waitForLoadAddThirdLayout
		$I->click(".action-default.scalable.action-add"); // stepKey: clickAddLayoutUpdateAddThirdLayout
		$I->comment("Exiting Action Group [AddThirdLayout] AdminWidgetAddLayoutUpdateActionGroup");
		$I->seeNumberOfElements("#page_group_container > .fieldset-wrapper.page_group_container > div.fieldset-wrapper-title > div > .action-default.action-delete", "3"); // stepKey: seeThreeDeleteButtons
		$I->comment("Entering Action Group [DeleteFirstLayoutForWidget] AdminWidgetDeleteLayoutUpdateActionGroup");
		$I->click("#page_group_container > div:first-of-type > div.fieldset-wrapper-title > div > .action-default.action-delete"); // stepKey: clickFirstDeleteButtonDeleteFirstLayoutForWidget
		$I->comment("Exiting Action Group [DeleteFirstLayoutForWidget] AdminWidgetDeleteLayoutUpdateActionGroup");
		$I->seeNumberOfElements("#page_group_container > .fieldset-wrapper.page_group_container > div.fieldset-wrapper-title > div > .action-default.action-delete", "2"); // stepKey: seeTwoDeleteButtons
		$I->comment("Entering Action Group [DeleteSecondLayoutForWidget] AdminWidgetDeleteLayoutUpdateActionGroup");
		$I->click("#page_group_container > div:first-of-type > div.fieldset-wrapper-title > div > .action-default.action-delete"); // stepKey: clickFirstDeleteButtonDeleteSecondLayoutForWidget
		$I->comment("Exiting Action Group [DeleteSecondLayoutForWidget] AdminWidgetDeleteLayoutUpdateActionGroup");
		$I->seeNumberOfElements("#page_group_container > .fieldset-wrapper.page_group_container > div.fieldset-wrapper-title > div > .action-default.action-delete", "1"); // stepKey: seeOneDeleteButtons
		$I->comment("Entering Action Group [DeleteThirdLayoutForWidget] AdminWidgetDeleteLayoutUpdateActionGroup");
		$I->click("#page_group_container > div:first-of-type > div.fieldset-wrapper-title > div > .action-default.action-delete"); // stepKey: clickFirstDeleteButtonDeleteThirdLayoutForWidget
		$I->comment("Exiting Action Group [DeleteThirdLayoutForWidget] AdminWidgetDeleteLayoutUpdateActionGroup");
		$I->seeNumberOfElements("#page_group_container > .fieldset-wrapper.page_group_container > div.fieldset-wrapper-title > div > .action-default.action-delete", "0"); // stepKey: seeZeroDeleteButtons
	}
}
