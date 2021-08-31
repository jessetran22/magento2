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
 * @Title("MC-37892: Reset Widget")
 * @Description("Check that admin user can reset widget form after filling out all information<h3>Test files</h3>app/code/Magento/Widget/Test/Mftf/Test/AdminResetWidgetTest.xml<br>")
 * @TestCaseId("MC-37892")
 * @group widget
 */
class AdminResetWidgetTestCest
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
		$I->comment("Entering Action Group [deleteWidget] AdminDeleteWidgetActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/widget_instance/"); // stepKey: amOnAdminDeleteWidget
		$I->waitForPageLoad(30); // stepKey: waitWidgetsLoadDeleteWidget
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteWidget
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteWidgetWaitForPageLoad
		$I->fillField("#widgetInstanceGrid_filter_title", "TestWidget" . msq("ProductsListWidget")); // stepKey: fillTitleDeleteWidget
		$I->click(".action-default.scalable.action-secondary"); // stepKey: clickContinueDeleteWidget
		$I->click("#widgetInstanceGrid_table>tbody>tr:nth-child(1)"); // stepKey: clickSearchResultDeleteWidget
		$I->waitForPageLoad(30); // stepKey: waitForResultLoadDeleteWidget
		$I->click("#delete"); // stepKey: clickDeleteDeleteWidget
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteWidgetWaitForPageLoad
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxLoadDeleteWidget
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteWidget
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteWidgetWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteLoadDeleteWidget
		$I->see("The widget instance has been deleted", "#messages div.message-success"); // stepKey: seeSuccessDeleteWidget
		$I->comment("Exiting Action Group [deleteWidget] AdminDeleteWidgetActionGroup");
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
	 * @Features({"Widget"})
	 * @Stories({"CMS Widgets"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminResetWidgetTest(AcceptanceTester $I)
	{
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/widget_instance/new/"); // stepKey: amOnAdminNewWidgetPage
		$I->comment("Entering Action Group [firstSetTypeAndDesign] AdminSetWidgetTypeAndDesignActionGroup");
		$I->waitForElementVisible("#code", 30); // stepKey: waitForTypeInputVisibleFirstSetTypeAndDesign
		$I->selectOption("#code", "Catalog Products List"); // stepKey: setWidgetTypeFirstSetTypeAndDesign
		$I->selectOption("#theme_id", "Magento Luma"); // stepKey: setWidgetDesignThemeFirstSetTypeAndDesign
		$I->comment("Exiting Action Group [firstSetTypeAndDesign] AdminSetWidgetTypeAndDesignActionGroup");
		$I->click(".page-actions-buttons button#reset"); // stepKey: resetInstance
		$I->waitForPageLoad(30); // stepKey: resetInstanceWaitForPageLoad
		$I->dontSeeInField("#code", "Catalog Products List"); // stepKey: dontSeeTypeAfterReset
		$I->dontSeeInField("#theme_id", "Magento Luma"); // stepKey: dontSeeDesignAfterReset
		$I->comment("Entering Action Group [setTypeAndDesignAfterReset] AdminSetWidgetTypeAndDesignActionGroup");
		$I->waitForElementVisible("#code", 30); // stepKey: waitForTypeInputVisibleSetTypeAndDesignAfterReset
		$I->selectOption("#code", "Catalog Products List"); // stepKey: setWidgetTypeSetTypeAndDesignAfterReset
		$I->selectOption("#theme_id", "Magento Luma"); // stepKey: setWidgetDesignThemeSetTypeAndDesignAfterReset
		$I->comment("Exiting Action Group [setTypeAndDesignAfterReset] AdminSetWidgetTypeAndDesignActionGroup");
		$I->click("#continue_button"); // stepKey: clickContinue
		$I->waitForPageLoad(30); // stepKey: clickContinueWaitForPageLoad
		$I->comment("Entering Action Group [setNameAndStore] AdminSetWidgetNameAndStoreActionGroup");
		$I->waitForElementVisible("#title", 30); // stepKey: waitForWidgetTitleInputVisibleSetNameAndStore
		$I->fillField("#title", "TestWidget" . msq("ProductsListWidget")); // stepKey: fillTitleSetNameAndStore
		$I->selectOption("#store_ids", ["All Store Views"]); // stepKey: setWidgetStoreIdSetNameAndStore
		$I->fillField("#sort_order", "0"); // stepKey: fillSortOrderSetNameAndStore
		$I->comment("Exiting Action Group [setNameAndStore] AdminSetWidgetNameAndStoreActionGroup");
		$I->click(".page-actions-buttons button#reset"); // stepKey: resetNameAndStore
		$I->waitForPageLoad(30); // stepKey: resetNameAndStoreWaitForPageLoad
		$I->dontSeeInField("#title", "TestWidget" . msq("ProductsListWidget")); // stepKey: dontSeeNameAfterReset
		$I->dontSeeInField("#store_ids", "All Store Views"); // stepKey: dontSeeStoreAfterReset
		$I->dontSeeInField("#sort_order", "0"); // stepKey: dontSeeSortOrderAfterReset
		$I->comment("Entering Action Group [setNameAndStoreAfterReset] AdminSetWidgetNameAndStoreActionGroup");
		$I->waitForElementVisible("#title", 30); // stepKey: waitForWidgetTitleInputVisibleSetNameAndStoreAfterReset
		$I->fillField("#title", "TestWidget" . msq("ProductsListWidget")); // stepKey: fillTitleSetNameAndStoreAfterReset
		$I->selectOption("#store_ids", ["All Store Views"]); // stepKey: setWidgetStoreIdSetNameAndStoreAfterReset
		$I->fillField("#sort_order", "0"); // stepKey: fillSortOrderSetNameAndStoreAfterReset
		$I->comment("Exiting Action Group [setNameAndStoreAfterReset] AdminSetWidgetNameAndStoreActionGroup");
		$I->comment("Entering Action Group [saveWidgetAndContinue] AdminSaveAndContinueWidgetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageSaveWidgetAndContinue
		$I->click("#save_and_edit_button"); // stepKey: clickSaveWidgetSaveWidgetAndContinue
		$I->waitForPageLoad(30); // stepKey: clickSaveWidgetSaveWidgetAndContinueWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearedSaveWidgetAndContinue
		$I->see("The widget instance has been saved", "#messages div.message-success"); // stepKey: seeSuccessSaveWidgetAndContinue
		$I->comment("Exiting Action Group [saveWidgetAndContinue] AdminSaveAndContinueWidgetActionGroup");
		$I->click(".page-actions-buttons button#reset"); // stepKey: resetWidgetForm
		$I->waitForPageLoad(30); // stepKey: resetWidgetFormWaitForPageLoad
		$I->seeInField("#title", "TestWidget" . msq("ProductsListWidget")); // stepKey: seeNameAfterReset
		$I->seeInField("#store_ids", "All Store Views"); // stepKey: seeStoreAfterReset
		$I->seeInField("#sort_order", "0"); // stepKey: seeSortOrderAfterReset
		$I->seeInField(".admin__field-control select#instance_code", "Catalog Products List"); // stepKey: seeTypeAfterReset
		$I->seeInField("#theme_id", "Magento Luma"); // stepKey: seeThemeAfterReset
	}
}
