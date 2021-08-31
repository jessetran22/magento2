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
 * @Title("MC-5347: Delete created product URL rewrite")
 * @Description("Login as admin, create product with category and UrlRewrite, delete created URL rewrite<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminDeleteProductURLRewriteEntityTest.xml<br>")
 * @TestCaseId("MC-5347")
 * @group urlRewrite
 * @group mtf_migrated
 */
class AdminDeleteProductURLRewriteEntityTestCest
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
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"Delete Product UrlRewrite"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"UrlRewrite"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteProductURLRewriteEntityTest(AcceptanceTester $I)
	{
		$I->comment("Filter and Select the created Product");
		$I->comment("Entering Action Group [searchProduct] AdminSearchUrlRewriteProductBySkuActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/edit/product"); // stepKey: openUrlRewriteProductPageSearchProduct
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteProductPageToLoadSearchProduct
		$I->click("//button[@data-action='grid-filter-reset']"); // stepKey: clickOnResetFilterSearchProduct
		$I->waitForPageLoad(30); // stepKey: clickOnResetFilterSearchProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchProduct
		$I->fillField("//input[@name='sku']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterSearchProduct
		$I->click("//button[@data-action='grid-filter-apply']"); // stepKey: clickOnSearchFilterSearchProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSearchFilterSearchProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadSearchProduct
		$I->click("//tbody/tr/td[contains(@class,'col-sku')]"); // stepKey: clickOnFirstRowSearchProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductCategoryPageToLoadSearchProduct
		$I->comment("Exiting Action Group [searchProduct] AdminSearchUrlRewriteProductBySkuActionGroup");
		$I->comment("Update the Store, RequestPath, RedirectType and Description");
		$I->comment("Entering Action Group [addUrlRewrite] AdminAddUrlRewriteForProductActionGroup");
		$I->waitForElementVisible("//button[@class='action-default scalable save']", 30); // stepKey: waitForSkipCategoryButtonAddUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForSkipCategoryButtonAddUrlRewriteWaitForPageLoad
		$I->click("//button[@class='action-default scalable save']"); // stepKey: clickOnSkipCategoryButtonAddUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnSkipCategoryButtonAddUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageToLoadAddUrlRewrite
		$I->click("//select[@id='store_id']"); // stepKey: clickOnStoreAddUrlRewrite
		$I->click("//select[@id='store_id']//option[contains(., 'Default Store View')]"); // stepKey: clickOnStoreValueAddUrlRewrite
		$I->fillField("//input[@id='request_path']", "firstlevelsubcategory" . msq("FirstLevelSubCat") . "/testproductname" . msq("_defaultProduct") . ".html"); // stepKey: fillRequestPathAddUrlRewrite
		$I->click("//select[@id='redirect_type']"); // stepKey: selectRedirectTypeAddUrlRewrite
		$I->click("//select[@id='redirect_type']//option[contains(., 'Temporary (302)')]"); // stepKey: clickOnRedirectTypeValueAddUrlRewrite
		$I->fillField("#description", "End To End Test"); // stepKey: fillDescriptionAddUrlRewrite
		$I->click("#save"); // stepKey: clickOnSaveButtonAddUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonAddUrlRewriteWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSuccessSaveMessageAddUrlRewrite
		$I->comment("Exiting Action Group [addUrlRewrite] AdminAddUrlRewriteForProductActionGroup");
		$I->comment("Delete Created Rewrite, Assert Success Message");
		$I->comment("Entering Action Group [deleteCreatedRewrite] AdminDeleteUrlRewriteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageDeleteCreatedRewrite
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadDeleteCreatedRewrite
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteCreatedRewrite
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteCreatedRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadDeleteCreatedRewrite
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersDeleteCreatedRewrite
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersDeleteCreatedRewriteWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "firstlevelsubcategory" . msq("FirstLevelSubCat") . "/testproductname" . msq("_defaultProduct") . ".html"); // stepKey: fillRedirectPathFilterDeleteCreatedRewrite
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersDeleteCreatedRewrite
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersDeleteCreatedRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1DeleteCreatedRewrite
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//button[contains(@class, 'action-select')]"); // stepKey: clickOnRowSelectButtonDeleteCreatedRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnRowSelectButtonDeleteCreatedRewriteWaitForPageLoad
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//a[contains(., 'Edit')]"); // stepKey: clickOnEditButtonDeleteCreatedRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnEditButtonDeleteCreatedRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForEditPageToLoadDeleteCreatedRewrite
		$I->click("#delete"); // stepKey: clickOnDeleteButtonDeleteCreatedRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteButtonDeleteCreatedRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad2DeleteCreatedRewrite
		$I->waitForElementVisible("//button[@class='action-primary action-accept']", 30); // stepKey: waitForOkButtonToVisibleDeleteCreatedRewrite
		$I->waitForPageLoad(30); // stepKey: waitForOkButtonToVisibleDeleteCreatedRewriteWaitForPageLoad
		$I->click("//button[@class='action-primary action-accept']"); // stepKey: clickOnOkButtonDeleteCreatedRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnOkButtonDeleteCreatedRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad3DeleteCreatedRewrite
		$I->see("You deleted the URL rewrite.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCreatedRewrite
		$I->comment("Exiting Action Group [deleteCreatedRewrite] AdminDeleteUrlRewriteActionGroup");
		$I->comment("Assert Deleted Rewrite is Not in Grid");
		$I->comment("Entering Action Group [searchDeletedURLRewriteInGrid] AdminSearchDeletedUrlRewriteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchDeletedURLRewriteInGrid
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchDeletedURLRewriteInGrid
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchDeletedURLRewriteInGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchDeletedURLRewriteInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchDeletedURLRewriteInGrid
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchDeletedURLRewriteInGrid
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchDeletedURLRewriteInGridWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "firstlevelsubcategory" . msq("FirstLevelSubCat") . "/testproductname" . msq("_defaultProduct") . ".html"); // stepKey: fillRedirectPathFilterSearchDeletedURLRewriteInGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchDeletedURLRewriteInGrid
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchDeletedURLRewriteInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchDeletedURLRewriteInGrid
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: seeEmptyRecordMessageSearchDeletedURLRewriteInGrid
		$I->comment("Exiting Action Group [searchDeletedURLRewriteInGrid] AdminSearchDeletedUrlRewriteActionGroup");
		$I->comment("Assert Page By Url Rewrite is Not Found");
		$I->comment("Entering Action Group [amOnPage] AssertPageByUrlRewriteIsNotFoundActionGroup");
		$I->amOnPage("firstlevelsubcategory" . msq("FirstLevelSubCat") . "/testproductname" . msq("_defaultProduct") . ".html"); // stepKey: amOnPageAmOnPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAmOnPage
		$I->see("Whoops, our bad..."); // stepKey: seeWhoopsAmOnPage
		$I->comment("Exiting Action Group [amOnPage] AssertPageByUrlRewriteIsNotFoundActionGroup");
	}
}
