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
 * @Title("[NO TESTCASEID]: Admin mass delete widgets in grid")
 * @Description("Admin select widgets in grid and try to mass delete action, will show pop-up with confirm action<h3>Test files</h3>app/code/Magento/Widget/Test/Mftf/Test/AdminContentWidgetsMassDeletesTest.xml<br>")
 * @group widget
 */
class AdminContentWidgetsMassDeletesTestCest
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
	 * @Stories({"Widget mass delete"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminContentWidgetsMassDeletesTest(AcceptanceTester $I)
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
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappear1
		$I->comment("Entering Action Group [addWidgetForTest1] AdminCreateAndSaveWidgetActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/widget_instance/new/"); // stepKey: amOnAdminNewWidgetPageAddWidgetForTest1
		$I->selectOption("#code", "Catalog Products List"); // stepKey: setWidgetTypeAddWidgetForTest1
		$I->selectOption("#theme_id", "Magento Luma"); // stepKey: setWidgetDesignThemeAddWidgetForTest1
		$I->click("#continue_button"); // stepKey: clickContinueAddWidgetForTest1
		$I->waitForPageLoad(30); // stepKey: clickContinueAddWidgetForTest1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForContinueAddWidgetForTest1
		$I->waitForElementVisible("#title", 30); // stepKey: waitForTitleAddWidgetForTest1
		$I->fillField("#title", "TestWidget" . msq("ProductsListWidget")); // stepKey: fillTitleAddWidgetForTest1
		$I->selectOption("#store_ids", "All Store Views"); // stepKey: setWidgetStoreIdsAddWidgetForTest1
		$I->click(".action-default.scalable.action-add"); // stepKey: clickAddLayoutUpdateAddWidgetForTest1
		$I->waitForElementVisible("#widget_instance[0][page_group]", 30); // stepKey: waitForLayoutUpdateAddWidgetForTest1
		$I->comment("BIC workaround");
		$I->comment("BIC workaround");
		$I->comment("BIC workaround");
		$I->comment("BIC workaround");
		$I->selectOption("#widget_instance[0][page_group]", "All Pages"); // stepKey: setDisplayOnAddWidgetForTest1
		$I->waitForPageLoad(30); // stepKey: waitForLoadAddWidgetForTest1
		$I->selectOption("#all_pages_0>table>tbody>tr>td:nth-child(1)>div>div>select", "Main Content Area"); // stepKey: setContainerAddWidgetForTest1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddWidgetForTest1
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageAddWidgetForTest1
		$I->click("#widget_instace_tabs_properties_section"); // stepKey: clickWidgetOptionsAddWidgetForTest1
		$I->waitForPageLoad(30); // stepKey: waitForWidgetOptionsAddWidgetForTest1
		$I->click("#save"); // stepKey: clickSaveWidgetAddWidgetForTest1
		$I->waitForPageLoad(30); // stepKey: clickSaveWidgetAddWidgetForTest1WaitForPageLoad
		$I->see("The widget instance has been saved", "#messages div.message-success"); // stepKey: seeSuccessAddWidgetForTest1
		$I->comment("Exiting Action Group [addWidgetForTest1] AdminCreateAndSaveWidgetActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappear2
		$I->comment("Entering Action Group [addWidgetForTest2] AdminCreateAndSaveWidgetActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/widget_instance/new/"); // stepKey: amOnAdminNewWidgetPageAddWidgetForTest2
		$I->selectOption("#code", "Catalog Products List"); // stepKey: setWidgetTypeAddWidgetForTest2
		$I->selectOption("#theme_id", "Magento Luma"); // stepKey: setWidgetDesignThemeAddWidgetForTest2
		$I->click("#continue_button"); // stepKey: clickContinueAddWidgetForTest2
		$I->waitForPageLoad(30); // stepKey: clickContinueAddWidgetForTest2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForContinueAddWidgetForTest2
		$I->waitForElementVisible("#title", 30); // stepKey: waitForTitleAddWidgetForTest2
		$I->fillField("#title", "TestWidget" . msq("ProductsListWidget")); // stepKey: fillTitleAddWidgetForTest2
		$I->selectOption("#store_ids", "All Store Views"); // stepKey: setWidgetStoreIdsAddWidgetForTest2
		$I->click(".action-default.scalable.action-add"); // stepKey: clickAddLayoutUpdateAddWidgetForTest2
		$I->waitForElementVisible("#widget_instance[0][page_group]", 30); // stepKey: waitForLayoutUpdateAddWidgetForTest2
		$I->comment("BIC workaround");
		$I->comment("BIC workaround");
		$I->comment("BIC workaround");
		$I->comment("BIC workaround");
		$I->selectOption("#widget_instance[0][page_group]", "All Pages"); // stepKey: setDisplayOnAddWidgetForTest2
		$I->waitForPageLoad(30); // stepKey: waitForLoadAddWidgetForTest2
		$I->selectOption("#all_pages_0>table>tbody>tr>td:nth-child(1)>div>div>select", "Main Content Area"); // stepKey: setContainerAddWidgetForTest2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddWidgetForTest2
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageAddWidgetForTest2
		$I->click("#widget_instace_tabs_properties_section"); // stepKey: clickWidgetOptionsAddWidgetForTest2
		$I->waitForPageLoad(30); // stepKey: waitForWidgetOptionsAddWidgetForTest2
		$I->click("#save"); // stepKey: clickSaveWidgetAddWidgetForTest2
		$I->waitForPageLoad(30); // stepKey: clickSaveWidgetAddWidgetForTest2WaitForPageLoad
		$I->see("The widget instance has been saved", "#messages div.message-success"); // stepKey: seeSuccessAddWidgetForTest2
		$I->comment("Exiting Action Group [addWidgetForTest2] AdminCreateAndSaveWidgetActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappear4
		$I->comment("Entering Action Group [navigateToContentWidgetsPageSecond] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToContentWidgetsPageSecond
		$I->click("li[data-ui-id='menu-magento-backend-content']"); // stepKey: clickOnMenuItemNavigateToContentWidgetsPageSecond
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToContentWidgetsPageSecondWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-widget-cms-widget-instance']"); // stepKey: clickOnSubmenuItemNavigateToContentWidgetsPageSecond
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToContentWidgetsPageSecondWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToContentWidgetsPageSecond] AdminNavigateMenuActionGroup");
		$I->comment("Entering Action Group [seePageTitleSecond] AdminAssertPageTitleActionGroup");
		$I->see("Widgets", ".page-title-wrapper h1"); // stepKey: assertPageTitleSeePageTitleSecond
		$I->comment("Exiting Action Group [seePageTitleSecond] AdminAssertPageTitleActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->comment("Entering Action Group [massWidgetDelete] AdminMassDeleteWidgetActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/widget_instance/"); // stepKey: visitAdminWidetPageMassWidgetDelete
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersMassWidgetDelete
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersMassWidgetDeleteWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappear1MassWidgetDelete
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadMassWidgetDelete
		$I->click("#widgetInstanceGrid_massaction-mass-select"); // stepKey: massActionSelectClickMassWidgetDelete
		$I->click("//*[@id='widgetInstanceGrid_massaction-mass-select']//option[@value='selectAll']"); // stepKey: massActionSelectOptionAllClickMassWidgetDelete
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappear2MassWidgetDelete
		$I->click("//*[@id='widgetInstanceGrid_massaction-select']//option[contains(., 'Action')]"); // stepKey: massActionSelectActionClickMassWidgetDelete
		$I->click("//*[@id='widgetInstanceGrid_massaction-select']//option[@value='delete']"); // stepKey: massActionSelectActionDeleteClickMassWidgetDelete
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappear3MassWidgetDelete
		$I->click("#widgetInstanceGrid_massaction-form button.action-default"); // stepKey: massActionSelectActionDeleteSubmitClick1MassWidgetDelete
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappear4MassWidgetDelete
		$I->seeElement(".modal-popup.confirm._show .action-dismiss"); // stepKey: widgetViewModalDismissSeeElementMassWidgetDelete
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3MassWidgetDelete
		$I->seeElement(".modal-popup.confirm._show .action-close"); // stepKey: widgetViewModalCloseSeeElementMassWidgetDelete
		$I->click(".modal-popup.confirm._show .action-dismiss"); // stepKey: widgetViewModalDismissClickMassWidgetDelete
		$I->waitForElementNotVisible(".modal-popup.confirm._show .action-dismiss", 30); // stepKey: waitForModalClosedMassWidgetDelete
		$I->seeElement("table.data-grid tbody tr[data-role=row]:nth-of-type(1) td[data-column=instance_id]"); // stepKey: widgetViewGridRowSeeElementMassWidgetDelete
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad4MassWidgetDelete
		$I->waitForElementVisible("table.data-grid tbody tr[data-role=row]:nth-of-type(1) td[data-column=instance_id]", 30); // stepKey: widgetViewGridInstanceIdWaitForElementVisibleMassWidgetDelete
		$I->click("#widgetInstanceGrid_massaction-form button.action-default"); // stepKey: massActionSelectActionDeleteSubmitClick2MassWidgetDelete
		$I->waitForElementVisible(".modal-popup.confirm._show .action-accept", 30); // stepKey: waitForModalVisibleMassWidgetDelete
		$I->click(".modal-popup.confirm._show .action-accept"); // stepKey: widgetViewModalAcceptClickMassWidgetDelete
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad5MassWidgetDelete
		$I->waitForElementVisible("table.data-grid tbody tr[data-role=row]:nth-of-type(1)", 30); // stepKey: widgetViewGridInstanceRowWaitForElementVisibleMassWidgetDelete
		$I->dontSeeElement("table.data-grid tbody tr[data-role=row]:nth-of-type(1) td[data-column=instance_id]"); // stepKey: widgetViewGridRowDontSeeElementMassWidgetDelete
		$I->comment("Exiting Action Group [massWidgetDelete] AdminMassDeleteWidgetActionGroup");
	}
}
