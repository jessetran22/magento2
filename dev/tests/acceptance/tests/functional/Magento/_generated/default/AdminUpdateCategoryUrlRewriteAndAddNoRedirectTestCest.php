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
 * @Title("MC-5355: Update Category URL Rewrites, no redirect type")
 * @Description("Login as Admin and update category Url Rewrite and add redirect type No<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminUpdateCategoryUrlRewriteAndAddNoRedirectTest.xml<br>")
 * @TestCaseId("MC-5355")
 * @group mtf_migrated
 */
class AdminUpdateCategoryUrlRewriteAndAddNoRedirectTestCest
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
		$I->createEntity("category", "hook", "SimpleSubCategory", [], []); // stepKey: category
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
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
	 * @Stories({"Update URL rewrite"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"UrlRewrite"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateCategoryUrlRewriteAndAddNoRedirectTest(AcceptanceTester $I)
	{
		$I->comment("Search and Select Edit option for created category in grid");
		$I->comment("Entering Action Group [editUrlRewrite] AdminSearchAndSelectUrlRewriteInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageEditUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadEditUrlRewrite
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersEditUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersEditUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadEditUrlRewrite
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersEditUrlRewrite
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersEditUrlRewriteWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('category', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: fillRequestPathFilterEditUrlRewrite
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersEditUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersEditUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1EditUrlRewrite
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//button[contains(@class, 'action-select')]"); // stepKey: clickOnRowSelectButtonEditUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnRowSelectButtonEditUrlRewriteWaitForPageLoad
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//a[contains(., 'Edit')]"); // stepKey: clickOnEditButtonEditUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnEditButtonEditUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForEditPageToLoadEditUrlRewrite
		$I->comment("Exiting Action Group [editUrlRewrite] AdminSearchAndSelectUrlRewriteInGridActionGroup");
		$I->comment("Open UrlRewrite Edit page and update the fields");
		$I->comment("Entering Action Group [updateCategoryUrlRewrite] AdminUpdateUrlRewriteActionGroup");
		$I->click("//select[@id='store_id']"); // stepKey: clickOnStoreUpdateCategoryUrlRewrite
		$I->click("//select[@id='store_id']//option[contains(., 'Default Store View')]"); // stepKey: clickOnStoreValueUpdateCategoryUrlRewrite
		$I->fillField("//input[@id='request_path']", msq("defaultUrlRewrite") . "test-test-test.html"); // stepKey: fillRequestPathUpdateCategoryUrlRewrite
		$I->click("//select[@id='redirect_type']"); // stepKey: selectRedirectTypeUpdateCategoryUrlRewrite
		$I->click("//select[@id='redirect_type']//option[contains(., 'No')]"); // stepKey: selectRedirectTypeValueUpdateCategoryUrlRewrite
		$I->fillField("#description", "Update Category Url Rewrite"); // stepKey: fillDescriptionUpdateCategoryUrlRewrite
		$I->click("#save"); // stepKey: clickOnSaveButtonUpdateCategoryUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonUpdateCategoryUrlRewriteWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSuccessSaveMessageUpdateCategoryUrlRewrite
		$I->comment("Exiting Action Group [updateCategoryUrlRewrite] AdminUpdateUrlRewriteActionGroup");
		$I->comment("Open Category Page and Get Category ID");
		$I->comment("Entering Action Group [getCategoryId] OpenCategoryFromCategoryTreeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageGetCategoryId
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadGetCategoryId
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeGetCategoryId
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadGetCategoryId
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('category', 'name', 'test') . "')]"); // stepKey: selectCategoryGetCategoryId
		$I->waitForPageLoad(30); // stepKey: selectCategoryGetCategoryIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGetCategoryId
		$I->waitForElementVisible("h1.page-title", 30); // stepKey: waitForCategoryTitleGetCategoryId
		$I->comment("Exiting Action Group [getCategoryId] OpenCategoryFromCategoryTreeActionGroup");
		$categoryId = $I->grabFromCurrentUrl("#\/([0-9]*)?\/$#"); // stepKey: categoryId
		$I->comment("Assert category Url Rewrite in grid");
		$I->comment("Entering Action Group [searchByNewRequestPath] AdminSearchByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchByNewRequestPath
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchByNewRequestPath
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchByNewRequestPath
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchByNewRequestPathWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchByNewRequestPath
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchByNewRequestPath
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchByNewRequestPathWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", msq("defaultUrlRewrite") . "test-test-test.html"); // stepKey: fillRedirectPathFilterSearchByNewRequestPath
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchByNewRequestPath
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchByNewRequestPathWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchByNewRequestPath
		$I->see(msq("defaultUrlRewrite") . "test-test-test.html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectPathForOldUrlSearchByNewRequestPath
		$I->see("catalog/category/view/id/{$categoryId}", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheTargetPathSearchByNewRequestPath
		$I->see("No", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectTypeForOldUrlSearchByNewRequestPath
		$I->comment("Exiting Action Group [searchByNewRequestPath] AdminSearchByRequestPathActionGroup");
		$I->comment("Assert Category redirect in Store Front");
		$I->comment("Entering Action Group [verifyCategoryInStoreFront] AssertStorefrontUrlRewriteRedirectActionGroup");
		$I->amOnPage(msq("defaultUrlRewrite") . "test-test-test.html"); // stepKey: openCategoryInStorefrontVerifyCategoryInStoreFront
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadVerifyCategoryInStoreFront
		$I->seeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('category', 'name', 'test') . "')]]"); // stepKey: seeCategoryOnStoreNavigationBarVerifyCategoryInStoreFront
		$I->waitForPageLoad(30); // stepKey: seeCategoryOnStoreNavigationBarVerifyCategoryInStoreFrontWaitForPageLoad
		$I->seeElement("#page-title-heading span"); // stepKey: seeCategoryInTitleVerifyCategoryInStoreFront
		$I->comment("Exiting Action Group [verifyCategoryInStoreFront] AssertStorefrontUrlRewriteRedirectActionGroup");
	}
}
