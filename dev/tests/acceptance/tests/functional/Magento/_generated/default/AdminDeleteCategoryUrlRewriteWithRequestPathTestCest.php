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
 * @Title("MC-5349: Delete category URL rewrite, with request path")
 * @Description("Delete category URL rewrite, with request path<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminDeleteCategoryUrlRewriteWithRequestPathTest.xml<br>")
 * @TestCaseId("MC-5349")
 * @group urlRewrite
 * @group mtf_migrated
 */
class AdminDeleteCategoryUrlRewriteWithRequestPathTestCest
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
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->createEntity("category", "hook", "_defaultCategory", [], []); // stepKey: category
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
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
	 * @Features({"UrlRewrite"})
	 * @Stories({"Delete custom URL rewrite"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteCategoryUrlRewriteWithRequestPathTest(AcceptanceTester $I)
	{
		$I->comment("Create the Category Url Rewrite");
		$I->comment("Entering Action Group [addUrlRewriteSecondTime] AdminAddUrlRewriteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/edit/id/"); // stepKey: openUrlRewriteEditPageAddUrlRewriteSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadAddUrlRewriteSecondTime
		$I->click("//select[@id='entity-type-selector']"); // stepKey: clickOnCustonUrlRewriteAddUrlRewriteSecondTime
		$I->click("//select[@id='entity-type-selector']/option[contains(.,'For Category')]"); // stepKey: selectForCategoryAddUrlRewriteSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForCategoryEditSectionToLoadAddUrlRewriteSecondTime
		$I->click("//li[contains(@class,'active-category jstree-open')]/a[contains(., '" . $I->retrieveEntityField('category', 'name', 'test') . "')]"); // stepKey: selectCategoryInTreeAddUrlRewriteSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddUrlRewriteSecondTime
		$I->click("//select[@id='store_id']"); // stepKey: clickOnStoreAddUrlRewriteSecondTime
		$I->click("//select[@id='store_id']//option[contains(., 'Default Store View')]"); // stepKey: clickOnStoreValueAddUrlRewriteSecondTime
		$I->fillField("//input[@id='request_path']", "newrequestpath.html"); // stepKey: fillRequestPathAddUrlRewriteSecondTime
		$I->click("//select[@id='redirect_type']"); // stepKey: selectRedirectTypeAddUrlRewriteSecondTime
		$I->click("//select[@id='redirect_type']//option[contains(., 'No')]"); // stepKey: clickOnRedirectTypeValueAddUrlRewriteSecondTime
		$I->fillField("#description", "End To End Test"); // stepKey: fillDescriptionAddUrlRewriteSecondTime
		$I->click("#save"); // stepKey: clickOnSaveButtonAddUrlRewriteSecondTime
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonAddUrlRewriteSecondTimeWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSuccessSaveMessageAddUrlRewriteSecondTime
		$I->comment("Exiting Action Group [addUrlRewriteSecondTime] AdminAddUrlRewriteActionGroup");
		$I->comment("Delete the Category Url Rewrite");
		$I->comment("Entering Action Group [deleteCustomUrlRewriteSecondTime] AdminDeleteUrlRewriteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageDeleteCustomUrlRewriteSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadDeleteCustomUrlRewriteSecondTime
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteCustomUrlRewriteSecondTime
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteCustomUrlRewriteSecondTimeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadDeleteCustomUrlRewriteSecondTime
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersDeleteCustomUrlRewriteSecondTime
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersDeleteCustomUrlRewriteSecondTimeWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "newrequestpath.html"); // stepKey: fillRedirectPathFilterDeleteCustomUrlRewriteSecondTime
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersDeleteCustomUrlRewriteSecondTime
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersDeleteCustomUrlRewriteSecondTimeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1DeleteCustomUrlRewriteSecondTime
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//button[contains(@class, 'action-select')]"); // stepKey: clickOnRowSelectButtonDeleteCustomUrlRewriteSecondTime
		$I->waitForPageLoad(30); // stepKey: clickOnRowSelectButtonDeleteCustomUrlRewriteSecondTimeWaitForPageLoad
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//a[contains(., 'Edit')]"); // stepKey: clickOnEditButtonDeleteCustomUrlRewriteSecondTime
		$I->waitForPageLoad(30); // stepKey: clickOnEditButtonDeleteCustomUrlRewriteSecondTimeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForEditPageToLoadDeleteCustomUrlRewriteSecondTime
		$I->click("#delete"); // stepKey: clickOnDeleteButtonDeleteCustomUrlRewriteSecondTime
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteButtonDeleteCustomUrlRewriteSecondTimeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad2DeleteCustomUrlRewriteSecondTime
		$I->waitForElementVisible("//button[@class='action-primary action-accept']", 30); // stepKey: waitForOkButtonToVisibleDeleteCustomUrlRewriteSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForOkButtonToVisibleDeleteCustomUrlRewriteSecondTimeWaitForPageLoad
		$I->click("//button[@class='action-primary action-accept']"); // stepKey: clickOnOkButtonDeleteCustomUrlRewriteSecondTime
		$I->waitForPageLoad(30); // stepKey: clickOnOkButtonDeleteCustomUrlRewriteSecondTimeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad3DeleteCustomUrlRewriteSecondTime
		$I->see("You deleted the URL rewrite.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCustomUrlRewriteSecondTime
		$I->comment("Exiting Action Group [deleteCustomUrlRewriteSecondTime] AdminDeleteUrlRewriteActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessageSecondTime] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleAssertSuccessMessageSecondTime
		$I->see("You deleted the URL rewrite.", "#messages div.message-success"); // stepKey: verifyMessageAssertSuccessMessageSecondTime
		$I->comment("Exiting Action Group [assertSuccessMessageSecondTime] AssertMessageInAdminPanelActionGroup");
		$I->comment("Verify AssertPageByUrlRewriteIsNotFound");
		$I->comment("Entering Action Group [checkUrlOnFrontendSecondTime] AssertPageByUrlRewriteIsNotFoundActionGroup");
		$I->amOnPage("newrequestpath.html"); // stepKey: amOnPageCheckUrlOnFrontendSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadCheckUrlOnFrontendSecondTime
		$I->see("Whoops, our bad..."); // stepKey: seeWhoopsCheckUrlOnFrontendSecondTime
		$I->comment("Exiting Action Group [checkUrlOnFrontendSecondTime] AssertPageByUrlRewriteIsNotFoundActionGroup");
	}
}
