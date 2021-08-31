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
 * @Title("MC-5336: Create category URL rewrite, with temporary redirect")
 * @Description("Login as admin and create category UrlRewrite with Temporary redirect<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminCreateCategoryUrlRewriteAndAddTemporaryRedirectTest.xml<br>")
 * @TestCaseId("MC-5336")
 * @group mtf_migrated
 */
class AdminCreateCategoryUrlRewriteAndAddTemporaryRedirectTestCest
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
		$I->deleteEntity("category", "hook"); // stepKey: deleteRootCategory
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
	 * @Stories({"Create category URL rewrite"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"UrlRewrite"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCategoryUrlRewriteAndAddTemporaryRedirectTest(AcceptanceTester $I)
	{
		$I->comment("Open Url Rewrite Index Page and update the Custom Url Rewrite, Store, Request Path, Redirect Type and Description");
		$I->comment("Entering Action Group [addUrlRewrite] AdminAddUrlRewriteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/edit/id/"); // stepKey: openUrlRewriteEditPageAddUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadAddUrlRewrite
		$I->click("//select[@id='entity-type-selector']"); // stepKey: clickOnCustonUrlRewriteAddUrlRewrite
		$I->click("//select[@id='entity-type-selector']/option[contains(.,'For Category')]"); // stepKey: selectForCategoryAddUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForCategoryEditSectionToLoadAddUrlRewrite
		$I->click("//li[contains(@class,'active-category jstree-open')]/a[contains(., '" . $I->retrieveEntityField('category', 'name', 'test') . "')]"); // stepKey: selectCategoryInTreeAddUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddUrlRewrite
		$I->click("//select[@id='store_id']"); // stepKey: clickOnStoreAddUrlRewrite
		$I->click("//select[@id='store_id']//option[contains(., 'Default Store View')]"); // stepKey: clickOnStoreValueAddUrlRewrite
		$I->fillField("//input[@id='request_path']", "newrequestpath.html"); // stepKey: fillRequestPathAddUrlRewrite
		$I->click("//select[@id='redirect_type']"); // stepKey: selectRedirectTypeAddUrlRewrite
		$I->click("//select[@id='redirect_type']//option[contains(., 'Temporary (302)')]"); // stepKey: clickOnRedirectTypeValueAddUrlRewrite
		$I->fillField("#description", "End To End Test"); // stepKey: fillDescriptionAddUrlRewrite
		$I->click("#save"); // stepKey: clickOnSaveButtonAddUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonAddUrlRewriteWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSuccessSaveMessageAddUrlRewrite
		$I->comment("Exiting Action Group [addUrlRewrite] AdminAddUrlRewriteActionGroup");
		$I->comment("Assert Redirect path, Target Path and Redirect type in grid");
		$I->comment("Entering Action Group [searchByRequestPath] AdminSearchByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchByRequestPath
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchByRequestPath
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchByRequestPath
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchByRequestPathWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchByRequestPath
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchByRequestPath
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchByRequestPathWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "newrequestpath.html"); // stepKey: fillRedirectPathFilterSearchByRequestPath
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchByRequestPath
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchByRequestPathWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchByRequestPath
		$I->see("newrequestpath.html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectPathForOldUrlSearchByRequestPath
		$I->see($I->retrieveEntityField('category', 'name_lwr', 'test') . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheTargetPathSearchByRequestPath
		$I->see("Temporary (302)", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectTypeForOldUrlSearchByRequestPath
		$I->comment("Exiting Action Group [searchByRequestPath] AdminSearchByRequestPathActionGroup");
		$I->comment("Assert Updated path directs to the category storefront");
		$I->comment("Entering Action Group [openStorefrontUrlRedirectPath] AssertStorefrontUrlRewriteRedirectActionGroup");
		$I->amOnPage("newrequestpath.html"); // stepKey: openCategoryInStorefrontOpenStorefrontUrlRedirectPath
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenStorefrontUrlRedirectPath
		$I->seeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('category', 'name', 'test') . "')]]"); // stepKey: seeCategoryOnStoreNavigationBarOpenStorefrontUrlRedirectPath
		$I->waitForPageLoad(30); // stepKey: seeCategoryOnStoreNavigationBarOpenStorefrontUrlRedirectPathWaitForPageLoad
		$I->seeElement("#page-title-heading span"); // stepKey: seeCategoryInTitleOpenStorefrontUrlRedirectPath
		$I->comment("Exiting Action Group [openStorefrontUrlRedirectPath] AssertStorefrontUrlRewriteRedirectActionGroup");
	}
}
