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
 * @Title("MC-5343: Create custom URL rewrite, permanent")
 * @Description("Login as Admin and create custom UrlRewrite and add redirect type permenent<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminCreateCustomCategoryUrlRewriteAndAddPermanentRedirectTest.xml<br>")
 * @TestCaseId("MC-5343")
 * @group mtf_migrated
 */
class AdminCreateCustomCategoryUrlRewriteAndAddPermanentRedirectTestCest
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
		$I->comment("Entering Action Group [deleteCustomUrlRewrite] AdminDeleteUrlRewriteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadDeleteCustomUrlRewrite
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteCustomUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadDeleteCustomUrlRewrite
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersDeleteCustomUrlRewriteWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "FirstLevelSubCategory" . msq("FirstLevelSubCat") . ".html"); // stepKey: fillRedirectPathFilterDeleteCustomUrlRewrite
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersDeleteCustomUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1DeleteCustomUrlRewrite
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//button[contains(@class, 'action-select')]"); // stepKey: clickOnRowSelectButtonDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnRowSelectButtonDeleteCustomUrlRewriteWaitForPageLoad
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//a[contains(., 'Edit')]"); // stepKey: clickOnEditButtonDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnEditButtonDeleteCustomUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForEditPageToLoadDeleteCustomUrlRewrite
		$I->click("#delete"); // stepKey: clickOnDeleteButtonDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteButtonDeleteCustomUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad2DeleteCustomUrlRewrite
		$I->waitForElementVisible("//button[@class='action-primary action-accept']", 30); // stepKey: waitForOkButtonToVisibleDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForOkButtonToVisibleDeleteCustomUrlRewriteWaitForPageLoad
		$I->click("//button[@class='action-primary action-accept']"); // stepKey: clickOnOkButtonDeleteCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnOkButtonDeleteCustomUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad3DeleteCustomUrlRewrite
		$I->see("You deleted the URL rewrite.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCustomUrlRewrite
		$I->comment("Exiting Action Group [deleteCustomUrlRewrite] AdminDeleteUrlRewriteActionGroup");
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
	 * @Stories({"Create custom URL rewrite"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Features({"UrlRewrite"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCustomCategoryUrlRewriteAndAddPermanentRedirectTest(AcceptanceTester $I)
	{
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
		$I->comment("Open UrlRewrite Edit page and update the fields and fill the created category Target Path");
		$I->comment("Entering Action Group [addCustomUrlRewrite] AdminAddCustomUrlRewriteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/edit/id/"); // stepKey: openUrlRewriteEditPageAddCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadAddCustomUrlRewrite
		$I->click("//select[@id='entity-type-selector']"); // stepKey: clickOnCustonUrlRewriteAddCustomUrlRewrite
		$I->click("//select[@id='entity-type-selector']/option[contains(.,'Custom')]"); // stepKey: selectCustomAddCustomUrlRewrite
		$I->click("//select[@id='store_id']"); // stepKey: clickOnStoreAddCustomUrlRewrite
		$I->click("//select[@id='store_id']//option[contains(., 'Default Store View')]"); // stepKey: clickOnStoreValueAddCustomUrlRewrite
		$I->fillField("//input[@id='request_path']", "FirstLevelSubCategory" . msq("FirstLevelSubCat") . ".html"); // stepKey: fillRequestPathAddCustomUrlRewrite
		$I->fillField("//input[@id='target_path']", "catalog/category/view/id/{$categoryId}"); // stepKey: fillTargetPathAddCustomUrlRewrite
		$I->click("//select[@id='redirect_type']"); // stepKey: selectRedirectTypeAddCustomUrlRewrite
		$I->click("//select[@id='redirect_type']//option[contains(., 'Permanent (301)')]"); // stepKey: selectRedirectTypeValueAddCustomUrlRewrite
		$I->fillField("#description", "End To End Test"); // stepKey: fillDescriptionAddCustomUrlRewrite
		$I->click("#save"); // stepKey: clickOnSaveButtonAddCustomUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonAddCustomUrlRewriteWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSuccessSaveMessageAddCustomUrlRewrite
		$I->comment("Exiting Action Group [addCustomUrlRewrite] AdminAddCustomUrlRewriteActionGroup");
		$I->comment("Assert updated category Url Rewrite in grid");
		$I->comment("Entering Action Group [searchByCategoryRequestPath] AdminSearchByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchByCategoryRequestPath
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchByCategoryRequestPath
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchByCategoryRequestPath
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchByCategoryRequestPathWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchByCategoryRequestPath
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchByCategoryRequestPath
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchByCategoryRequestPathWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('category', 'name', 'test') . ".html"); // stepKey: fillRedirectPathFilterSearchByCategoryRequestPath
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchByCategoryRequestPath
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchByCategoryRequestPathWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchByCategoryRequestPath
		$I->see($I->retrieveEntityField('category', 'name', 'test') . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectPathForOldUrlSearchByCategoryRequestPath
		$I->see("catalog/category/view/id/{$categoryId}", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheTargetPathSearchByCategoryRequestPath
		$I->see("No", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectTypeForOldUrlSearchByCategoryRequestPath
		$I->comment("Exiting Action Group [searchByCategoryRequestPath] AdminSearchByRequestPathActionGroup");
		$I->comment("Assert initial category Url Rewrite in grid");
		$I->comment("Entering Action Group [searchByNewRequestPath] AdminSearchByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchByNewRequestPath
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchByNewRequestPath
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchByNewRequestPath
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchByNewRequestPathWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchByNewRequestPath
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchByNewRequestPath
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchByNewRequestPathWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "FirstLevelSubCategory" . msq("FirstLevelSubCat") . ".html"); // stepKey: fillRedirectPathFilterSearchByNewRequestPath
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchByNewRequestPath
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchByNewRequestPathWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchByNewRequestPath
		$I->see("FirstLevelSubCategory" . msq("FirstLevelSubCat") . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectPathForOldUrlSearchByNewRequestPath
		$I->see("catalog/category/view/id/{$categoryId}", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheTargetPathSearchByNewRequestPath
		$I->see("Permanent (301)", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectTypeForOldUrlSearchByNewRequestPath
		$I->comment("Exiting Action Group [searchByNewRequestPath] AdminSearchByRequestPathActionGroup");
		$I->comment("Assert updated Category redirect in Store Front");
		$I->comment("Entering Action Group [verifyCategoryInStoreFront] AssertStorefrontUrlRewriteRedirectActionGroup");
		$I->amOnPage("FirstLevelSubCategory" . msq("FirstLevelSubCat") . ".html"); // stepKey: openCategoryInStorefrontVerifyCategoryInStoreFront
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadVerifyCategoryInStoreFront
		$I->seeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('category', 'name', 'test') . "')]]"); // stepKey: seeCategoryOnStoreNavigationBarVerifyCategoryInStoreFront
		$I->waitForPageLoad(30); // stepKey: seeCategoryOnStoreNavigationBarVerifyCategoryInStoreFrontWaitForPageLoad
		$I->seeElement("#page-title-heading span"); // stepKey: seeCategoryInTitleVerifyCategoryInStoreFront
		$I->comment("Exiting Action Group [verifyCategoryInStoreFront] AssertStorefrontUrlRewriteRedirectActionGroup");
		$I->comment("Assert initial Category redirect in Store Front");
		$I->comment("Entering Action Group [verifyCategoryInStoreFront1] AssertStorefrontUrlRewriteRedirectActionGroup");
		$I->amOnPage("catalog/category/view/id/{$categoryId}"); // stepKey: openCategoryInStorefrontVerifyCategoryInStoreFront1
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadVerifyCategoryInStoreFront1
		$I->seeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('category', 'name', 'test') . "')]]"); // stepKey: seeCategoryOnStoreNavigationBarVerifyCategoryInStoreFront1
		$I->waitForPageLoad(30); // stepKey: seeCategoryOnStoreNavigationBarVerifyCategoryInStoreFront1WaitForPageLoad
		$I->seeElement("#page-title-heading span"); // stepKey: seeCategoryInTitleVerifyCategoryInStoreFront1
		$I->comment("Exiting Action Group [verifyCategoryInStoreFront1] AssertStorefrontUrlRewriteRedirectActionGroup");
	}
}
