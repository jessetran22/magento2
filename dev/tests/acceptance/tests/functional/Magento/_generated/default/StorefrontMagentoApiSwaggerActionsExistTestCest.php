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
 * @Title("[NO TESTCASEID]: Authorize and logout on Swagger page")
 * @Description("Authorize and logout on Swagger page use API Key<h3>Test files</h3>app/code/Magento/Swagger/Test/Mftf/Test/StorefrontMagentoApiSwaggerActionsExistTest.xml<br>")
 */
class StorefrontMagentoApiSwaggerActionsExistTestCest
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
        $this->helperContainer->create("Magento\Tax\Test\Mftf\Helper\TaxHelpers");
        $this->helperContainer->create("Magento\Backend\Test\Mftf\Helper\CurlHelpers");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$getOtpCode = $I->getOTP(); // stepKey: getOtpCode
		$createAdminTokenFields['otp'] = $getOtpCode;
		$I->createEntity("createAdminToken", "hook", "adminApiToken", [], $createAdminTokenFields); // stepKey: createAdminToken
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
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
	 * @Features({"Swagger"})
	 * @Stories({"Swagger via the Storefront"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontMagentoApiSwaggerActionsExistTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToSwaggerPage] StorefrontGoToSwaggerPageActionGroup");
		$I->amOnPage("/swagger"); // stepKey: goToSwaggerPageGoToSwaggerPage
		$I->waitForPageLoad(30); // stepKey: waitForSwaggerPageLoadGoToSwaggerPage
		$I->comment("Exiting Action Group [goToSwaggerPage] StorefrontGoToSwaggerPageActionGroup");
		$I->comment("Entering Action Group [applyAdminToken] StorefrontApplyAdminTokenOnSwaggerPageActionGroup");
		$I->click(".btn.authorize.unlocked"); // stepKey: clickAuthorizeButtonApplyAdminToken
		$I->waitForElementVisible(".auth-container .wrapper input", 30); // stepKey: waitModalPopUpApplyAdminToken
		$I->clearField(".auth-container .wrapper input"); // stepKey: clearApiTokenFieldApplyAdminToken
		$I->fillField(".auth-container .wrapper input", $I->retrieveEntityField('createAdminToken', 'return', 'test')); // stepKey: fillApiTokenInputApplyAdminToken
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->click(".btn.auth.authorize"); // stepKey: clickModalAuthorizeButtonApplyAdminToken
		$I->waitForPageLoad(30); // stepKey: waitForPageReloadedApplyAdminToken
		$I->click(".btn.modal-btn.auth.btn-done"); // stepKey: clickModalCloseButtonApplyAdminToken
		$I->comment("Exiting Action Group [applyAdminToken] StorefrontApplyAdminTokenOnSwaggerPageActionGroup");
		$I->seeElement("#operations-tag-storeStoreRepositoryV1"); // stepKey: assertTitleOfFirstAction
		$I->seeElement("#operations-tag-quoteCartRepositoryV1"); // stepKey: assertTitleOfSecondAction
		$I->seeElement("#operations-tag-catalogProductRepositoryV1"); // stepKey: assertTitleOfThirdAction
		$I->comment("Entering Action Group [swaggerLogout] StorefrontSwaggerLogoutActionGroup");
		$I->click(".btn.authorize.locked"); // stepKey: clickAuthorizeButtonSwaggerLogout
		$I->click(".btn.modal-btn.auth"); // stepKey: clickModalLogoutButtonSwaggerLogout
		$I->waitForPageLoad(30); // stepKey: waitForPageReloadedSwaggerLogout
		$I->click(".btn.modal-btn.auth.btn-done"); // stepKey: clickModalCloseButtonSwaggerLogout
		$I->seeElementInDOM(".btn.authorize.unlocked"); // stepKey: assertIsLoggedOutSwaggerLogout
		$I->comment("Exiting Action Group [swaggerLogout] StorefrontSwaggerLogoutActionGroup");
	}
}
