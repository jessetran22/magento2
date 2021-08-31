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
 * @Title("[NO TESTCASEID]: Admin should be able to create a new search term")
 * @Description("Admin should be able to create a new search term using search terms grid<h3>Test files</h3>app/code/Magento/AdvancedSearch/Test/Mftf/Test/AdminAddSearchTermTest.xml<br>")
 * @group AdvancedSearch
 */
class AdminAddSearchTermTestCest
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
	 * @Features({"AdvancedSearch"})
	 * @Stories({"Add a new search term"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAddSearchTermTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToSearchTermPage] AdminOpenNewSearchTermsPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/search/term/new/"); // stepKey: amOnSearchTermsFormNavigateToSearchTermPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToSearchTermPage
		$I->comment("Exiting Action Group [navigateToSearchTermPage] AdminOpenNewSearchTermsPageActionGroup");
		$I->comment("Entering Action Group [fillNewSearchTermData] AdminFillSearchTermActionGroup");
		$I->comment("Fill form fields");
		$I->fillField("#query_text", "books" . msq("SearchTerms")); // stepKey: fillFieldSearchQueryFillNewSearchTermData
		$I->selectOption("#store_id", "Default Store View"); // stepKey: selectStoreViewFillNewSearchTermData
		$I->fillField("#redirect", "http://sample.com"); // stepKey: fillFieldRedirectUrlFillNewSearchTermData
		$I->selectOption("#display_in_terms", "1"); // stepKey: selectSuggestedTermsFillNewSearchTermData
		$I->comment("Exiting Action Group [fillNewSearchTermData] AdminFillSearchTermActionGroup");
		$I->comment("Entering Action Group [saveSearchTerm] AdminSaveSearchTermActionGroup");
		$I->comment("Click save action and verify success message");
		$I->click("#save"); // stepKey: clickSaveSearchButtonSaveSearchTerm
		$I->waitForPageLoad(30); // stepKey: clickSaveSearchButtonSaveSearchTermWaitForPageLoad
		$I->comment("Exiting Action Group [saveSearchTerm] AdminSaveSearchTermActionGroup");
		$I->comment("Entering Action Group [assertSaveSearchTermSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleAssertSaveSearchTermSuccessMessage
		$I->see("You saved the search term.", "#messages div.message-success"); // stepKey: verifyMessageAssertSaveSearchTermSuccessMessage
		$I->comment("Exiting Action Group [assertSaveSearchTermSuccessMessage] AssertMessageInAdminPanelActionGroup");
	}
}
