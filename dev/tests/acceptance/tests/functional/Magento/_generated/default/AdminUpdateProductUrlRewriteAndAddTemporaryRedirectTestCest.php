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
 * @Title("MC-5351: Update Product URL Rewrites")
 * @Description("Login as Admin and update product UrlRewrite and add Temporary redirect type<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminUpdateProductUrlRewriteAndAddTemporaryRedirectTest.xml<br>")
 * @TestCaseId("MC-5351")
 * @group mtf_migrated
 */
class AdminUpdateProductUrlRewriteAndAddTemporaryRedirectTestCest
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
		$I->createEntity("createProduct", "hook", "defaultSimpleProduct", [], []); // stepKey: createProduct
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
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"URL Rewrite"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"UrlRewrite"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateProductUrlRewriteAndAddTemporaryRedirectTest(AcceptanceTester $I)
	{
		$I->comment("Search and Select Edit option for created product in grid");
		$I->comment("Entering Action Group [editUrlRewrite] AdminSearchAndSelectUrlRewriteInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageEditUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadEditUrlRewrite
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersEditUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersEditUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadEditUrlRewrite
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersEditUrlRewrite
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersEditUrlRewriteWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('createProduct', 'name', 'test')); // stepKey: fillRequestPathFilterEditUrlRewrite
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
		$I->fillField("//input[@id='request_path']", msq("updateUrlRewrite") . "test-aspx-test.aspx"); // stepKey: fillRequestPathUpdateCategoryUrlRewrite
		$I->click("//select[@id='redirect_type']"); // stepKey: selectRedirectTypeUpdateCategoryUrlRewrite
		$I->click("//select[@id='redirect_type']//option[contains(., 'Temporary (302)')]"); // stepKey: selectRedirectTypeValueUpdateCategoryUrlRewrite
		$I->fillField("#description", "Update Url Rewrite"); // stepKey: fillDescriptionUpdateCategoryUrlRewrite
		$I->click("#save"); // stepKey: clickOnSaveButtonUpdateCategoryUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonUpdateCategoryUrlRewriteWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSuccessSaveMessageUpdateCategoryUrlRewrite
		$I->comment("Exiting Action Group [updateCategoryUrlRewrite] AdminUpdateUrlRewriteActionGroup");
		$I->comment("Assert product Url Rewrite in StoreFront");
		$I->comment("Entering Action Group [assertProductUrlRewriteInStoreFront] AssertStorefrontProductRedirectActionGroup");
		$I->amOnPage(msq("updateUrlRewrite") . "test-aspx-test.aspx"); // stepKey: openCategoryInStorefrontAssertProductUrlRewriteInStoreFront
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadAssertProductUrlRewriteInStoreFront
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameInStoreFrontPageAssertProductUrlRewriteInStoreFront
		$I->see($I->retrieveEntityField('createProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: seeProductSkuInStoreFrontPageAssertProductUrlRewriteInStoreFront
		$I->comment("Exiting Action Group [assertProductUrlRewriteInStoreFront] AssertStorefrontProductRedirectActionGroup");
	}
}
